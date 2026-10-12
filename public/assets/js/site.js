
(()=>{'use strict';
const services=[{"id":"branding","index":2,"title":"برندسازی و","desc":"طراحی هویت بصری","icon":"img52837428315365567501"},{"id":"marketing","index":1,"title":"سوشال مدیا و","desc":"دیجیتال مارکتینگ","icon":"imgMarketingIconContainer","orange":true},{"id":"uiux","index":0,"title":"توسعه نرم‌افزار و","desc":"طراحی رابط و تجربه کاربری","icon":"imgIconUiux"},{"id":"packaging","index":5,"title":"طراحی، چاپ و","desc":"بسته‌بندی محصول","icon":"imgIconPrint","orange":true},{"id":"video","index":4,"title":"تدوین ویدیو و","desc":"تولید محتوای تبلیغاتی","icon":"imgVideoIconContainer"},{"id":"academy","index":3,"title":"آکادمی، آموزش و","desc":"توسعه سرمایه انسانی","icon":"imgAcademyIconContainer","orange":true}],projects=[{"name":"SHOPERO","asset":"imgShopero1","id":"shopero"},{"name":"IMA MOVIES","asset":"imgIma2","id":"ima"},{"name":"EXLOOT","asset":"imgExloot2","id":"exloot"}],excerpt="با پیشرفت فناوری و تغییرات سریع در سبک زندگی، نیازهای کاربران به خدمات دیجیتال به طور چشمگیری افزایش یافته است. این تحولات به آژانس‌های دیجیتال مارکتینگ این امکان را می‌دهد که به شیوه‌های جدیدی به مشتریان خود خدمات ارائه دهند.";
const contact=document.getElementById('contact-dialog'),preview=document.getElementById('preview-dialog'),caseDialog=document.getElementById('case-dialog'),lightbox=document.getElementById('lightbox'),form=document.getElementById('brief-form');
function showModal(d){if(!d.open)d.showModal();document.body.style.overflow='hidden'}function openDialog(dialog){document.querySelectorAll('dialog[open]').forEach(d=>{if(d!==dialog)d.close()});showModal(dialog)}
document.querySelectorAll('dialog').forEach(d=>{d.querySelector('[data-close]').addEventListener('click',()=>d.close());d.addEventListener('close',()=>{if(!document.querySelector('dialog[open]'))document.body.style.overflow=''});d.addEventListener('click',e=>{if(e.target===d){const r=d.getBoundingClientRect();if(e.clientX<r.left||e.clientX>r.right||e.clientY<r.top||e.clientY>r.bottom)d.close()}})});
function clearContactForm(){form.reset();document.getElementById('contact-form-content').hidden=false;document.getElementById('form-success').hidden=true;document.getElementById('form-status').textContent='';for(const name of ['name','phone','email','service','details']){const field=form.elements[name];field.setCustomValidity('');field.removeAttribute('aria-invalid');const error=document.getElementById('error-'+name);error.textContent='';error.hidden=true}}
function openContact(mode,service){clearContactForm();document.getElementById('contact-title').textContent=mode==='consultation'?'مشاوره رایگان':'شروع پروژه';if(service)form.elements.service.value=service;else if(mode==='consultation')form.elements.service.value='consultation';openDialog(contact);startPrompt()}
document.querySelectorAll('[data-contact]').forEach(b=>b.addEventListener('click',()=>openContact(b.dataset.contact)));
document.querySelectorAll('[data-service]').forEach(b=>b.addEventListener('click',()=>openContact('project',b.dataset.service)));
const projectButtons=[...document.querySelectorAll('[data-project]')];
let previewIndex=0;
function presentProject(index){
  previewIndex=Math.max(0,Math.min(projectButtons.length-1,index));
  const button=projectButtons[previewIndex],source=button.querySelector('img'),image=source.cloneNode();
  document.getElementById('preview-title').textContent=button.querySelector('.project-name').textContent;
  document.getElementById('preview-description').textContent=button.querySelector('.project-description').textContent;
  image.className='';image.loading='eager';image.src=source.currentSrc||source.src;
  document.getElementById('preview-image').replaceChildren(image);loadOriginalImage(source,image);
  document.getElementById('preview-prev').disabled=previewIndex===0;
  document.getElementById('preview-next').disabled=previewIndex===projectButtons.length-1;
  document.getElementById('preview-position').textContent=(previewIndex+1).toLocaleString('fa-IR')+' / '+projectButtons.length.toLocaleString('fa-IR');
  openDialog(preview);preview.querySelector('.preview-scroll').scrollTop=0;
  if(!window.matchMedia('(prefers-reduced-motion: reduce)').matches&&image.animate)image.animate([{opacity:0,transform:'translateY(10px)'},{opacity:1,transform:'none'}],{duration:300,easing:'ease-out'});
}
projectButtons.forEach((button,index)=>button.addEventListener('click',()=>presentProject(index)));
document.getElementById('preview-prev').addEventListener('click',()=>presentProject(previewIndex-1));
document.getElementById('preview-next').addEventListener('click',()=>presentProject(previewIndex+1));
if('IntersectionObserver' in window&&!window.matchMedia('(prefers-reduced-motion: reduce)').matches){
  const reveal=new IntersectionObserver(entries=>{entries.forEach(entry=>{if(!entry.isIntersecting)return;reveal.unobserve(entry.target);if(entry.target.animate)entry.target.animate([{opacity:0,transform:'translateY(18px)'},{opacity:1,transform:'none'}],{duration:420,delay:Number(entry.target.dataset.revealDelay||0),easing:'cubic-bezier(.2,.65,.3,1)'});})},{threshold:.12});
  document.querySelectorAll('.portfolio-grid .project-card').forEach((card,index)=>{card.dataset.revealDelay=String(index===0?0:(index-1)*65);reveal.observe(card)});
}
if('IntersectionObserver' in window&&!window.matchMedia('(prefers-reduced-motion: reduce)').matches){
  const sectionMotion=new IntersectionObserver(entries=>{entries.forEach(entry=>entry.target.classList.toggle('is-in-view',entry.isIntersecting))},{threshold:0.08});
  document.querySelectorAll('main section, .site-footer').forEach(section=>{section.classList.add('section-motion');sectionMotion.observe(section)});
}document.querySelectorAll('[data-case]').forEach(b=>b.addEventListener('click',()=>openDialog(caseDialog)));
contact.addEventListener('close',clearContactForm);
document.getElementById('success-close').addEventListener('click',()=>contact.close());
form.addEventListener('submit',e=>{e.preventDefault();if(!validateForm())return;const data=Object.fromEntries(new FormData(form));const statusEl=document.getElementById('form-status'),submitButton=form.querySelector('[type="submit"]');statusEl.textContent='در حال ارسال…';submitButton.disabled=true;fetch('/api/leads',{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json'},body:JSON.stringify(data)}).then(async res=>{const body=await res.json().catch(()=>({}));if(res.ok){document.getElementById('contact-form-content').hidden=true;const success=document.getElementById('form-success');success.hidden=false;success.focus();return}if(res.status===429){statusEl.textContent='تعداد درخواست‌ها زیاد است. لطفاً کمی بعد دوباره تلاش کنید.';return}if(res.status===422&&body.errors){const firstError=Object.values(body.errors)[0];statusEl.textContent=Array.isArray(firstError)?firstError[0]:body.message||'لطفاً فیلدهای مشخص‌شده را اصلاح کنید.';return}statusEl.textContent=body.message||'خطایی رخ داد. لطفاً دوباره تلاش کنید.'}).catch(()=>{statusEl.textContent='خطای شبکه. لطفاً اتصال خود را بررسی کنید.'}).finally(()=>{submitButton.disabled=false})});

// Keep the case study open beneath its image viewer, including its scroll position.
const zoomToggle=document.getElementById('zoom-toggle'),zoomViewport=document.getElementById('lightbox-viewport'),zoomImage=document.getElementById('lightbox-img');
function setZoom(zoomed){lightbox.classList.toggle('is-zoomed',zoomed);zoomToggle.setAttribute('aria-pressed',String(zoomed));zoomToggle.textContent=zoomed?'نمایش کامل':'اندازهٔ واقعی';zoomViewport.scrollTop=0;zoomViewport.scrollLeft=0}
zoomToggle.addEventListener('click',()=>setZoom(!lightbox.classList.contains('is-zoomed')));
zoomImage.addEventListener('click',()=>setZoom(!lightbox.classList.contains('is-zoomed')));
const galleryButtons=[...document.querySelectorAll('#case-dialog [data-lightbox]')];
const previousImage=document.getElementById('gallery-prev'),nextImage=document.getElementById('gallery-next'),imageCount=document.getElementById('gallery-count'),imageStatus=document.getElementById('gallery-status');
let galleryIndex=0;
function imageReady(){imageStatus.hidden=true;zoomViewport.removeAttribute('aria-busy')}
zoomImage.addEventListener('load',imageReady);
zoomImage.addEventListener('error',()=>{zoomViewport.removeAttribute('aria-busy');imageStatus.textContent='تصویر بارگذاری نشد. تصویر دیگری را انتخاب کنید یا دوباره این تصویر را باز کنید.';imageStatus.hidden=false});

// Always display the embedded preview first; upgrade only after the local original loads.
function loadOriginalImage(source,target){
  const requested=source.getAttribute('data-src');if(!requested)return;
  const token=String(Number(target.dataset.loadVersion||0)+1);target.dataset.loadVersion=token;
  const fullImage=new Image();
  fullImage.onload=()=>{if(target.dataset.loadVersion===token)target.src=fullImage.src};
  fullImage.onerror=()=>{};
  fullImage.src=new URL(requested,source.baseURI).href;
}

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
  loadOriginalImage(source,zoomImage);
  if(zoomImage.complete&&zoomImage.naturalWidth)imageReady();
}
galleryButtons.forEach((button,index)=>button.addEventListener('click',()=>{showGalleryImage(index);showModal(lightbox)}));
previousImage.addEventListener('click',()=>showGalleryImage(galleryIndex-1));
nextImage.addEventListener('click',()=>showGalleryImage(galleryIndex+1));
lightbox.addEventListener('keydown',event=>{if(event.altKey||event.ctrlKey||event.metaKey||lightbox.classList.contains('is-zoomed'))return;
  if(event.key==='ArrowLeft'){event.preventDefault();if(!nextImage.disabled)showGalleryImage(galleryIndex+1)}
  if(event.key==='ArrowRight'){event.preventDefault();if(!previousImage.disabled)showGalleryImage(galleryIndex-1)}
});
lightbox.addEventListener('close',()=>setZoom(false));
// A rotating visual prompt never replaces the user's input or accessible field label.
const details=form.elements.details,prompt=document.querySelector('.project-prompt'),serviceWord=document.getElementById('rotating-service');
const serviceEntries=[...document.querySelectorAll('[data-service]')].map(button=>({id:button.dataset.service,title:button.querySelector('.service-title').textContent.trim()}));
const reducedMotion=window.matchMedia('(prefers-reduced-motion: reduce)');
let promptTimer,promptTransition,promptIndex=0;
function syncPrompt(){prompt.hidden=details.value.length>0}
function stopPrompt(){clearInterval(promptTimer);clearTimeout(promptTransition);serviceWord.classList.remove('is-changing')}
function startPrompt(){stopPrompt();syncPrompt();if(!contact.open||details.value||document.activeElement===details)return;
  promptIndex=Math.max(0,serviceEntries.findIndex(entry=>entry.id===form.elements.service.value));serviceWord.textContent=serviceEntries[promptIndex].title;
  if(reducedMotion.matches)return;
  promptTimer=setInterval(()=>{if(document.hidden||!contact.open||details.value||document.activeElement===details)return;
    serviceWord.classList.add('is-changing');promptTransition=setTimeout(()=>{promptIndex=(promptIndex+1)%serviceEntries.length;serviceWord.textContent=serviceEntries[promptIndex].title;serviceWord.classList.remove('is-changing')},180);
  },3200);
}
details.addEventListener('focus',stopPrompt);details.addEventListener('blur',startPrompt);
details.addEventListener('input',()=>{syncPrompt();if(details.value)stopPrompt()});
form.elements.service.addEventListener('change',startPrompt);
contact.addEventListener('close',stopPrompt);reducedMotion.addEventListener('change',startPrompt);syncPrompt();
function normalizePhone(value){return value.replace(/[۰-۹]/g,c=>String(c.charCodeAt(0)-1776)).replace(/[٠-٩]/g,c=>String(c.charCodeAt(0)-1632)).replace(/[\s()\-]/g,'')}
function validatePhone(){const value=form.elements.phone.value;const clean=normalizePhone(value);form.elements.phone.setCustomValidity(!value||/^\+?[0-9]{7,15}$/.test(clean)?'':'شمارهٔ تماس معتبر وارد کنید؛ مثلاً ۰۹۱۲۳۴۵۶۷۸۹.')}
form.elements.phone.addEventListener('input',validatePhone);


const validatedFields=['name','phone','email','service','details'];
function fieldMessage(field){
  const value=field.value.trim();
  if(field.name==='name'&&!value)return 'نام خود را وارد کنید.';
  if(field.name==='phone'){
    if(!value)return 'شمارهٔ تماس را وارد کنید.';
    if(!/^\+?[0-9]{7,15}$/.test(normalizePhone(value)))return 'شمارهٔ تماس معتبر وارد کنید؛ مثلاً ۰۹۱۲۳۴۵۶۷۸۹.';
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

})();

const heroAnimationContainer=document.querySelector('.hero-lottie');
if(heroAnimationContainer&&window.lottie&&!window.matchMedia('(prefers-reduced-motion: reduce)').matches){
  const heroAnimation=window.lottie.loadAnimation({container:heroAnimationContainer,renderer:'svg',loop:true,autoplay:false,path:heroAnimationContainer.dataset.lottie,rendererSettings:{preserveAspectRatio:'xMidYMid meet',progressiveLoad:true,hideOnTransparent:true}});
  heroAnimation.setSubframe(true);
  heroAnimation.addEventListener('loaded_images',()=>heroAnimationContainer.closest('.art-stage')?.classList.add('lottie-ready'));
  heroAnimation.addEventListener('data_failed',()=>heroAnimation.destroy());
  const heroVisibility=new IntersectionObserver(entries=>entries.forEach(entry=>{if(entry.isIntersecting)heroAnimation.play();else heroAnimation.pause()}),{threshold:.05});
  heroVisibility.observe(heroAnimationContainer);
}
