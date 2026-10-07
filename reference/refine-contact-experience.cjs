const fs=require('fs');
const {JSDOM,VirtualConsole}=require('./qa/node_modules/jsdom');
const file='felosi-home-before-about-v2.html';
let html=fs.readFileSync(file,'utf8');
const dom=new JSDOM(html,{virtualConsole:new VirtualConsole()});
const d=dom.window.document;
function edit(selector,fn){const node=d.querySelector(selector);if(!node)throw Error(selector);const old=node.outerHTML;fn(node);if(!html.includes(old))throw Error('Missing source: '+selector);html=html.replace(old,node.outerHTML)}
const header=d.querySelector('.site-header').outerHTML;
html=html.replace(header,`<header class="consultation-bar" id="top" data-od-id="consultation-bar"><a class="consultation-call" href="tel:+989109027628" aria-label="تماس تلفنی برای مشاوره رایگان" data-od-id="free-consultation">مشاوره رایگان</a></header>`);
edit('.hero',node=>{
  node.querySelector('.hero-copy>.eyebrow').remove();
  node.querySelectorAll('.hero-actions svg').forEach(el=>el.remove());
  const image=node.querySelector('.sculpture');
  image.src='assets/felosi-logo-sculpture.png';image.width=1254;image.height=1254;
  image.alt='نشان سه‌بعدی فلوسی با بافت مرواریدی و شیشه‌ای';
});
edit('#about-title',node=>node.textContent='فلوسی؛ همراه برند شما');
edit('[data-case="ebrahimi"]',node=>node.querySelectorAll('.project-action svg').forEach(el=>el.remove()));
edit('#brief-form',form=>{
  const email=form.elements.email.closest('label');
  email.insertAdjacentHTML('beforebegin',`<label>شمارهٔ تماس <span class="field-requirement">(الزامی)</span><input type="tel" name="phone" autocomplete="tel" inputmode="tel" dir="ltr" required minlength="7" maxlength="24" aria-describedby="phone-hint" data-od-id="brief-phone"><span id="phone-hint" class="field-hint">شماره‌ای که بتوانیم با شما تماس بگیریم.</span></label>`);
  const textarea=form.elements.details;
  textarea.removeAttribute('placeholder');textarea.id='brief-details';textarea.setAttribute('aria-describedby','details-hint');
  textarea.closest('label').innerHTML=`دربارهٔ پروژه<span class="project-details-field">${textarea.outerHTML}<span class="project-prompt" aria-hidden="true">از <span id="rotating-service" class="service-word">طراحی هویت بصری</span> شروع کنیم…</span></span><span id="details-hint" class="sr-only">از خدمت موردنیازتان شروع کنید و توضیح کوتاهی دربارهٔ پروژه بنویسید.</span>`;
});
edit('#lightbox',box=>{
  box.innerHTML=`<div class="dialog-head"><h2 id="lightbox-cap"></h2><button class="close-dialog" type="button" data-close aria-label="بستن تصویر" data-od-id="close-lightbox"><svg class="icon" aria-hidden="true"><use href="#i-close"></use></svg></button></div><div class="lightbox-tools"><button class="zoom-toggle" id="zoom-toggle" type="button" aria-pressed="false" data-od-id="image-zoom-toggle">اندازهٔ واقعی</button><span class="field-hint">برای دیدن جزئیات، تصویر را بزرگ کنید.</span></div><div class="lightbox-viewport" id="lightbox-viewport" tabindex="0" aria-label="تصویر بزرگ‌شده؛ برای حرکت از کلیدهای جهت استفاده کنید" data-od-id="image-zoom-viewport"><img id="lightbox-img" alt=""></div>`;
});
// Remove the navigation controller because the header is now a single call link.
const menuStart=html.indexOf("const menu=document.querySelector('.menu-toggle')");
const dialogsStart=html.indexOf("const contact=document.getElementById('contact-dialog')",menuStart);
if(menuStart<0||dialogsStart<0)throw Error('Missing navigation controller');
html=html.slice(0,menuStart)+html.slice(dialogsStart);
html=html.replace("openDialog(contact)}","openDialog(contact);startPrompt()}");
html=html.replace("['name','email','service','details']","['name','phone','email','service','details']");
html=html.replace("e.preventDefault();if(!form.reportValidity())return;","e.preventDefault();validatePhone();if(!form.reportValidity())return;");
html=html.replace("'نام: '+data.name,'ایمیل: '+data.email","'نام: '+data.name,'شماره تماس: '+normalizePhone(data.phone),'ایمیل: '+data.email");
const extraScript=`
// Keep the case study open beneath its image viewer, including its scroll position.
const zoomToggle=document.getElementById('zoom-toggle'),zoomViewport=document.getElementById('lightbox-viewport'),zoomImage=document.getElementById('lightbox-img');
function setZoom(zoomed){lightbox.classList.toggle('is-zoomed',zoomed);zoomToggle.setAttribute('aria-pressed',String(zoomed));zoomToggle.textContent=zoomed?'نمایش کامل':'اندازهٔ واقعی';zoomViewport.scrollTop=0;zoomViewport.scrollLeft=0}
zoomToggle.addEventListener('click',()=>setZoom(!lightbox.classList.contains('is-zoomed')));
zoomImage.addEventListener('click',()=>setZoom(!lightbox.classList.contains('is-zoomed')));
document.querySelectorAll('[data-lightbox]').forEach(button=>button.addEventListener('click',()=>{
  const source=button.querySelector('img');
  zoomImage.src=button.dataset.lightbox;zoomImage.alt=source.alt;
  zoomImage.width=source.width;zoomImage.height=source.height;
  document.getElementById('lightbox-cap').textContent=button.dataset.caption||source.alt;
  setZoom(false);showModal(lightbox);
}));
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
function normalizePhone(value){return value.replace(/[۰-۹]/g,c=>String(c.charCodeAt(0)-1776)).replace(/[٠-٩]/g,c=>String(c.charCodeAt(0)-1632)).replace(/[\\s()\\-]/g,'')}
function validatePhone(){const value=form.elements.phone.value;const clean=normalizePhone(value);form.elements.phone.setCustomValidity(!value||/^\\+?[0-9]{7,15}$/.test(clean)?'':'شمارهٔ تماس معتبر وارد کنید؛ مثلاً ۰۹۱۲۳۴۵۶۷۸۹.')}
form.elements.phone.addEventListener('input',validatePhone);
`;
html=html.replace("})();\n</script>",extraScript+"\n})();\n</script>");
if(!html.includes('function validatePhone')){
  html=html.replace(/\}\)\(\);\r?\n<\/script>/,extraScript+'\n})();\n</script>');
}
if(!html.includes('function validatePhone'))throw Error('Failed to add interactions');
const css=`
/* Single-page telephone banner. */
html{scroll-padding-top:64px}
.consultation-bar{position:sticky;top:0;z-index:10;background:var(--accent);color:var(--fg)}
.consultation-call{display:flex;align-items:center;justify-content:center;min-height:44px;width:100%;padding:10px 20px;font:500 14px/1.7 IRANSansX,sans-serif;background:var(--accent);color:var(--fg);transition:background .18s}
.consultation-call:hover{background:oklch(from var(--accent) calc(l + .08) c h);color:var(--fg)}
.consultation-call:active{background:oklch(from var(--accent) calc(l + .04) c h);color:var(--fg)}
.consultation-call:focus-visible{outline:2px solid var(--fg);outline-offset:-5px}
.hero-actions .button,.hero-actions .quiet-link{gap:0}
.portfolio-grid .project-card{transition:border-color .18s,box-shadow .18s}
.portfolio-grid .project-card:hover{transform:none;border-color:var(--muted);box-shadow:0 3px 12px oklch(from var(--fg) l c h / .045)}
.portfolio-grid .featured-project:hover{background:var(--fg);border-color:var(--muted)}
.close-dialog{display:grid;place-items:center;padding:0;line-height:1}
.close-dialog .icon{display:block;width:20px;height:20px;margin:0}
.field-hint,.field-requirement{font-size:12px;color:var(--muted);line-height:1.8}
.field-requirement{display:inline}
.form-grid label:has(.field-requirement){display:flex;flex-wrap:wrap;gap:6px}
.form-grid label:has(.field-requirement) input,.form-grid label:has(.field-requirement) .field-hint{flex-basis:100%}
.project-details-field{position:relative;display:block}
.project-details-field textarea{display:block;min-height:140px}
.project-prompt{position:absolute;top:12px;right:13px;left:13px;pointer-events:none;font-size:14px;line-height:2;color:var(--muted)}
.project-prompt[hidden],.project-details-field:focus-within .project-prompt{display:none}
.service-word{display:inline-block;opacity:1;transform:translateY(0);transition:opacity .18s,transform .18s;color:var(--fg)}
.service-word.is-changing{opacity:0;transform:translateY(4px)}
.lightbox{width:min(1280px,calc(100% - 24px));height:calc(100dvh - 24px);max-height:calc(100dvh - 24px);padding:16px;overflow:hidden}
.lightbox[open]{display:flex;flex-direction:column;gap:12px}
.lightbox .dialog-head{margin:0;flex-shrink:0}
.lightbox-tools{display:flex;align-items:center;gap:16px;flex-wrap:wrap}
.zoom-toggle{min-height:44px;border:1px solid var(--border);border-radius:8px;background:var(--surface);color:var(--fg);padding:8px 16px;font-size:13px}
.zoom-toggle:hover{background:var(--border);color:var(--fg)}
.lightbox-viewport{flex:1;min-height:0;overflow:auto;background:var(--surface);border-radius:8px;direction:ltr;overscroll-behavior:contain}
.lightbox-viewport:focus-visible{outline:3px solid var(--focus);outline-offset:-3px}
.lightbox .lightbox-viewport img{width:auto;height:auto;max-width:100%;max-height:calc(100dvh - 180px);margin:auto;object-fit:contain;border-radius:0;cursor:zoom-in}
.lightbox.is-zoomed .lightbox-viewport img{max-width:none;max-height:none;cursor:zoom-out}
@media(max-width:649px){
 .portfolio-grid .featured-project .project-action{grid-column:1/-1;grid-row:auto;width:auto;height:auto;min-height:44px;margin-top:8px;padding:8px 0 0;border:0;border-radius:0;font-size:12px;justify-content:flex-start;overflow:visible}
 .project-prompt{font-size:13px}
 .lightbox-tools{gap:8px}
 .lightbox-tools .field-hint{display:none}
}
@media(prefers-reduced-motion:reduce){.service-word{transition:none}}
`;
const point=html.lastIndexOf('</style>');html=html.slice(0,point)+css+html.slice(point);
const backup='reference/felosi-before-contact-v2.html';if(!fs.existsSync(backup))fs.copyFileSync(file,backup);
fs.writeFileSync(file,html,'utf8');dom.window.close();
console.log('Updated selected page: telephone header, hero brand artwork, project form, nested lightbox and restrained card hover.');
