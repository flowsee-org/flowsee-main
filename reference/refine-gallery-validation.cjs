const fs=require('fs');
const {JSDOM,VirtualConsole}=require('./qa/node_modules/jsdom');
const file='felosi-home-before-about-v2.html';
let html=fs.readFileSync(file,'utf8');
const d=new JSDOM(html,{virtualConsole:new VirtualConsole()}).window.document;
function edit(selector,fn){const el=d.querySelector(selector);if(!el)throw Error(selector);const old=el.outerHTML;fn(el);if(!html.includes(old))throw Error('Source mismatch '+selector);html=html.replace(old,el.outerHTML)}
const serviceCopy=d.querySelector('#services .section-description');html=html.replace(serviceCopy.outerHTML,'');
edit('#brief-form',form=>{
  form.noValidate=true;
  for(const name of ['name','phone','email','service','details']){
    const input=form.elements[name];input.id=input.id||'brief-'+name;
    const error=d.createElement('span');error.className='field-error';error.id='error-'+name;error.hidden=true;error.setAttribute('aria-live','polite');
    input.closest('label').append(error);input.setAttribute('aria-describedby',[input.getAttribute('aria-describedby'),error.id].filter(Boolean).join(' '));
  }
});
edit('#lightbox',box=>{
  const toolbar=box.querySelector('.lightbox-tools');
  toolbar.innerHTML=`<div class="gallery-nav" aria-label="جابه‌جایی بین تصاویر"><button type="button" class="gallery-button" id="gallery-prev" data-od-id="gallery-previous">قبلی</button><span id="gallery-count" class="gallery-count" aria-live="polite" aria-atomic="true"></span><button type="button" class="gallery-button" id="gallery-next" data-od-id="gallery-next">بعدی</button></div><button class="zoom-toggle" id="zoom-toggle" type="button" aria-pressed="false" data-od-id="image-zoom-toggle">اندازهٔ واقعی</button>`;
  box.querySelector('.lightbox-viewport').insertAdjacentHTML('beforebegin','<p id="gallery-status" class="gallery-status" role="status" aria-live="polite" hidden></p>');
});
html=html.replace("const image=b.querySelector('img').cloneNode();image.className='';image.removeAttribute('loading');","const source=b.querySelector('img'),image=source.cloneNode();image.className='';image.loading='eager';image.src=source.currentSrc||source.src;");
const start=html.indexOf("document.querySelectorAll('[data-lightbox]').forEach(button=>");
const end=html.indexOf("lightbox.addEventListener('close',()=>setZoom(false));",start);
if(start<0||end<0)throw Error('Missing gallery controller');
const gallery=`const galleryButtons=[...document.querySelectorAll('#case-dialog [data-lightbox]')];
const previousImage=document.getElementById('gallery-prev'),nextImage=document.getElementById('gallery-next'),imageCount=document.getElementById('gallery-count'),imageStatus=document.getElementById('gallery-status');
let galleryIndex=0;
function imageReady(){imageStatus.hidden=true;zoomViewport.removeAttribute('aria-busy')}
zoomImage.addEventListener('load',imageReady);
zoomImage.addEventListener('error',()=>{zoomViewport.removeAttribute('aria-busy');imageStatus.textContent='تصویر بارگذاری نشد. تصویر دیگری را انتخاب کنید یا دوباره این تصویر را باز کنید.';imageStatus.hidden=false});
function showGalleryImage(index){
  galleryIndex=Math.max(0,Math.min(galleryButtons.length-1,index));
  const button=galleryButtons[galleryIndex],source=button.querySelector('img');
  const resolvedSource=source.currentSrc||source.src;
  source.loading='eager';zoomImage.loading='eager';zoomImage.decoding='async';
  imageStatus.textContent='در حال بارگذاری تصویر…';imageStatus.hidden=false;zoomViewport.setAttribute('aria-busy','true');
  zoomImage.alt=source.alt;zoomImage.width=Number(source.getAttribute('width'));zoomImage.height=Number(source.getAttribute('height'));
  document.getElementById('lightbox-cap').textContent=button.dataset.caption||source.alt;
  imageCount.textContent=(galleryIndex+1).toLocaleString('fa-IR')+' / '+galleryButtons.length.toLocaleString('fa-IR');
  previousImage.disabled=galleryIndex===0;nextImage.disabled=galleryIndex===galleryButtons.length-1;
  setZoom(false);zoomImage.src=resolvedSource;
  if(zoomImage.complete&&zoomImage.naturalWidth)imageReady();
}
galleryButtons.forEach((button,index)=>button.addEventListener('click',()=>{showGalleryImage(index);showModal(lightbox)}));
previousImage.addEventListener('click',()=>showGalleryImage(galleryIndex-1));
nextImage.addEventListener('click',()=>showGalleryImage(galleryIndex+1));
lightbox.addEventListener('keydown',event=>{if(event.altKey||event.ctrlKey||event.metaKey||lightbox.classList.contains('is-zoomed'))return;
  if(event.key==='ArrowLeft'){event.preventDefault();if(!nextImage.disabled)showGalleryImage(galleryIndex+1)}
  if(event.key==='ArrowRight'){event.preventDefault();if(!previousImage.disabled)showGalleryImage(galleryIndex-1)}
});
`;
html=html.slice(0,start)+gallery+html.slice(end);
html=html.replace("validatePhone();if(!form.reportValidity())return;","if(!validateForm())return;");
const validation=`
const validatedFields=['name','phone','email','service','details'];
function fieldMessage(field){
  const value=field.value.trim();
  if(field.name==='name'&&!value)return 'نام خود را وارد کنید.';
  if(field.name==='phone'){
    if(!value)return 'شمارهٔ تماس را وارد کنید.';
    if(!/^\\+?[0-9]{7,15}$/.test(normalizePhone(value)))return 'شمارهٔ تماس معتبر وارد کنید؛ مثلاً ۰۹۱۲۳۴۵۶۷۸۹.';
  }
  if(field.name==='email'&&value&&field.validity.typeMismatch)return 'ایمیل را به شکل name@example.com وارد کنید.';
  if(field.name==='service'&&!value)return 'خدمت موردنظر را انتخاب کنید.';
  if(field.name==='details'&&!value)return 'توضیح کوتاهی دربارهٔ پروژه بنویسید.';
  if(field.maxLength>0&&value.length>field.maxLength)return 'متن واردشده بیش از حد طولانی است.';
  return '';
}
function validateField(field){
  const message=fieldMessage(field),error=document.getElementById('error-'+field.name);
  error.textContent=message;error.hidden=!message;
  field.setCustomValidity(message);
  if(message)field.setAttribute('aria-invalid','true');else field.removeAttribute('aria-invalid');
  return !message;
}
function validateForm(){
  const invalid=validatedFields.map(name=>form.elements[name]).filter(field=>!validateField(field));
  if(invalid.length){document.getElementById('form-status').textContent='لطفاً فیلدهای مشخص‌شده را اصلاح کنید.';invalid[0].focus();return false}
  document.getElementById('form-status').textContent='';return true;
}
for(const name of validatedFields){const field=form.elements[name];
  field.addEventListener('blur',()=>validateField(field));
  field.addEventListener('input',()=>{if(field.hasAttribute('aria-invalid'))validateField(field)});
  if(field.tagName==='SELECT')field.addEventListener('change',()=>validateField(field));
}
`;
html=html.replace(/\}\)\(\);\r?\n<\/script>/,validation+'\n})();\n</script>');
if(!html.includes('function validateForm'))throw Error('Validation insertion failed');
const css=`
/* White banner lettering, on a deeper orange for readable contrast. */
.consultation-bar,.consultation-call{background:oklch(from var(--accent) 55% c h);color:var(--bg)}
.consultation-call:hover{background:oklch(from var(--accent) 49% c h);color:var(--bg)}
.consultation-call:active{background:oklch(from var(--accent) 46% c h);color:var(--bg)}
.consultation-call:focus-visible{outline-color:var(--bg)}
/* Translucent, asymmetric orange glass behind the sculpture. */
.art-stage::before{inset:10% 7% 11% 8%;border-radius:38% 62% 56% 44% / 48% 34% 66% 52%;transform:rotate(-14deg);background:radial-gradient(ellipse at 24% 20%,oklch(from var(--bg) l c h / .95),transparent 58%),linear-gradient(145deg,oklch(from var(--accent) 96% .035 h / .48),oklch(from var(--accent) 86% .09 h / .6) 55%,oklch(from var(--accent) 77% .13 h / .24));border:1px solid oklch(from var(--bg) l c h / .85);box-shadow:inset 2px 3px 16px oklch(from var(--bg) l c h / .8),inset -8px -10px 26px oklch(from var(--accent) 76% .12 h / .1),0 12px 36px oklch(from var(--accent) 80% .09 h / .12);backdrop-filter:blur(16px)}
.field-error{display:block;width:100%;font-size:12px;line-height:1.9;color:var(--accent-ink)}
.field-error[hidden]{display:none}
.form-grid [aria-invalid="true"]{border-color:var(--accent-ink);box-shadow:0 0 0 1px var(--accent-ink)}
.form-grid [aria-invalid="true"]:focus-visible{outline-color:var(--accent-ink)}
.gallery-nav{display:flex;align-items:center;gap:12px}
.gallery-button{min-width:60px;min-height:44px;border:1px solid var(--border);border-radius:8px;padding:8px 14px;background:var(--bg);color:var(--fg);font-size:13px}
.gallery-button:hover{background:var(--surface);color:var(--fg);border-color:var(--muted)}
.gallery-button:disabled{opacity:.4;background:var(--bg);color:var(--fg);border-color:var(--border)}
.gallery-count{min-width:60px;text-align:center;font-size:13px;color:var(--muted)}
.lightbox-tools{justify-content:space-between}
.gallery-status{font-size:13px;line-height:1.8;color:var(--muted);margin:0}
.gallery-status[hidden]{display:none}
@media(max-width:649px){.gallery-nav{gap:6px}.gallery-button{min-width:48px;padding-inline:8px}.gallery-count{min-width:44px}.lightbox-tools .zoom-toggle{padding-inline:10px}}
`;
const lastStyle=html.lastIndexOf('</style>');html=html.slice(0,lastStyle)+css+html.slice(lastStyle);
fs.writeFileSync(file,html,'utf8');console.log('Updated banner, glass shape, gallery source resolution/navigation, and inline validation.');
