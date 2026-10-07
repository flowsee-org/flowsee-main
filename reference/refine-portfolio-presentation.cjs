const fs = require('fs');
const { JSDOM } = require('./qa/node_modules/jsdom');
const file = 'felosi-home-before-about-v2.html';
const original = fs.readFileSync(file, 'utf8');
const backup = 'reference/felosi-before-portfolio-redesign-v2.html';
if (!fs.existsSync(backup)) fs.writeFileSync(backup, original);
const dom = new JSDOM(original);
const d = dom.window.document;
const grid = d.querySelector('.portfolio-grid');
grid.prepend(grid.querySelector('.featured-project'));
grid.querySelectorAll('.project-name-en').forEach(el => el.remove());
const aboutPhone = d.querySelector('[data-od-id="about-phone"]');
aboutPhone.outerHTML = '<button type="button" class="button about-consultation" data-contact="consultation" data-od-id="about-consultation">مشاوره رایگان</button>';
d.querySelector('#articles').remove();
d.querySelectorAll('a[href="#articles"]').forEach(el => el.remove());
d.querySelector('#text-dialog').remove();
const preview = d.querySelector('#preview-dialog');
preview.innerHTML = `
<div class="project-window-bar" data-od-id="preview-toolbar"><span>منتخب پروژه‌های فلوسی</span><button class="close-dialog" type="button" data-close aria-label="بستن پروژه" data-od-id="close-preview"><svg class="icon" aria-hidden="true"><use href="#i-close"></use></svg></button></div>
<div class="preview-scroll" data-od-id="preview-scroll">
  <header class="project-intro" data-od-id="preview-intro"><div><span class="eyebrow">طراحی و تجربهٔ دیجیتال</span><h2 id="preview-title" dir="rtl" data-od-id="preview-title"></h2></div><p id="preview-description" data-od-id="preview-description"></p></header>
  <figure class="project-showcase" data-od-id="preview-artwork"><div id="preview-image"></div></figure>
  <div class="project-window-bottom" data-od-id="preview-bottom"><p>از ایدهٔ شما شروع کنیم.</p><button class="button primary" type="button" data-contact="project" data-od-id="preview-start-project">گفت‌وگو دربارهٔ پروژه</button></div>
</div>
<nav class="project-pagination" aria-label="مرور پروژه‌ها" data-od-id="preview-navigation"><button type="button" id="preview-prev" data-od-id="preview-previous">پروژهٔ قبلی</button><span id="preview-position" aria-live="polite" aria-atomic="true"></span><button type="button" id="preview-next" data-od-id="preview-next">پروژهٔ بعدی</button></nav>`;
const caseHero = d.querySelector('.cs-hero');
const intro = d.createElement('div');
intro.className = 'case-intro-copy';
for (const el of [...caseHero.children]) if (!el.matches('.meta')) intro.append(el);
caseHero.prepend(intro);
const caseService = caseHero.querySelector('.meta li:last-child .v');
caseService.textContent = 'لوگو و هویت بصری';
caseService.setAttribute('lang', 'fa');
caseService.setAttribute('dir', 'rtl');
const style = d.createElement('style');
style.id = 'portfolio-presentation-refinement';
style.textContent = `
/* Image-led portfolio; deliberate cover crops only on the homepage cards. */
.portfolio-grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:24px;align-items:start}
.portfolio-grid .project-card{border-radius:16px;box-shadow:none;transition:border-color 200ms ease;background:var(--bg);color:var(--fg);text-align:right}
.portfolio-grid .project-card:hover{transform:none;box-shadow:none;border-color:oklch(from var(--border) calc(l - .12) c h);background:var(--bg);color:var(--fg)}
.portfolio-grid .project-visual{display:block;position:relative;flex:none;aspect-ratio:2/1;overflow:hidden;background:var(--surface);min-width:0}
.portfolio-grid .project-image{display:block;width:100%;height:100%;max-width:none;object-fit:cover;object-position:center;transition:transform 350ms cubic-bezier(.2,.65,.3,1)}
.portfolio-grid .project-copy{padding:20px;gap:16px;min-width:0}
.portfolio-grid .project-title-stack{display:block;width:100%}
.portfolio-grid .project-name{font:500 21px/1.65 var(--display);letter-spacing:0}
.portfolio-grid .project-description{font-size:13px;line-height:1.9;margin-top:4px;min-height:0}
.portfolio-grid .project-card:not(.featured-project) .project-description{min-height:3.8em}
.portfolio-grid .project-arrow{width:40px;height:40px;border-color:var(--border);background:transparent;color:var(--fg);transition:background 200ms,border-color 200ms}
.portfolio-grid .project-card:hover .project-arrow{border-color:var(--fg);background:var(--fg);color:var(--bg)}
.portfolio-grid .featured-project{grid-column:1/-1;display:grid;grid-template-columns:minmax(0,1.8fr) minmax(0,1fr);direction:ltr;background:var(--fg);border-color:var(--fg)}
.portfolio-grid .featured-project:hover{background:var(--fg);color:var(--bg);border-color:var(--fg)}
.portfolio-grid .featured-project .project-visual{aspect-ratio:auto;align-self:stretch;min-height:340px}
.portfolio-grid .featured-project .project-image{position:absolute;inset:0}
.portfolio-grid .featured-project .project-copy{display:flex;flex-direction:column;justify-content:center;align-items:flex-start;padding:36px;gap:0;direction:rtl}
.portfolio-grid .featured-project .project-category{font-size:12px;margin-bottom:16px;color:oklch(from var(--bg) 80% c h)}
.portfolio-grid .featured-project .project-name{font-size:clamp(28px,3vw,38px);color:var(--bg)}
.portfolio-grid .featured-project .project-description{font-size:14px;margin-top:10px;color:oklch(from var(--bg) 80% c h)}
.portfolio-grid .featured-project .project-action{display:inline-flex;justify-content:center;align-items:center;align-self:flex-start;width:auto;height:auto;min-height:44px;padding:9px 16px;margin-top:28px;border:1px solid oklch(from var(--bg) l c h/.4);border-radius:8px;font-size:13px;line-height:1.7;color:var(--bg);background:transparent;overflow:visible;transition:border-color 200ms}
.portfolio-grid .featured-project:hover .project-action{border-color:var(--bg)}
@media(hover:hover) and (prefers-reduced-motion:no-preference){.portfolio-grid .project-card:hover .project-image{transform:scale(1.015)}}
.about-values li{border:0}
.about-lead .about-consultation{margin-top:24px;background:var(--bg);color:var(--fg);border:1px solid var(--bg);font-size:14px;padding:10px 22px;min-height:46px}
.about-lead .about-consultation:hover{background:var(--bg);color:var(--fg);box-shadow:0 0 0 3px oklch(from var(--bg) l c h/.2);transform:none}
.about-lead .about-consultation:focus-visible{outline-color:var(--bg)}
/* A generous project canvas with a persistent close control and project navigation. */
.preview-dialog{width:min(1200px,calc(100% - 40px));max-width:none;height:calc(100dvh - 40px);max-height:calc(100dvh - 40px);padding:0;border:1px solid var(--border);border-radius:20px;overflow:hidden;background:var(--bg)}
.preview-dialog[open]{display:flex;flex-direction:column}
.project-window-bar,.case-bar{flex:none;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:12px 24px;margin:0;background:var(--bg);border-bottom:1px solid var(--border)}
.project-window-bar>span,.case-bar-title{font:400 13px/1.7 var(--body);color:var(--muted)}
.preview-scroll{flex:1;min-height:0;overflow:auto;overscroll-behavior:contain}
.project-intro{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,.8fr);align-items:end;gap:24px;padding:32px 40px 28px}
.project-intro .eyebrow{font-size:12px;margin-bottom:6px}
.preview-dialog .project-intro h2{font:500 clamp(28px,3.8vw,46px)/1.6 var(--display);text-align:right}
.project-intro>p{color:var(--muted);font-size:16px;line-height:1.9;text-align:right;padding-bottom:8px}
.project-showcase{margin:0 24px;background:var(--surface);border-radius:12px;overflow:hidden}
.preview-dialog #preview-image img{width:100%;height:auto;max-width:100%;max-height:none;object-fit:contain;margin:0}
.project-window-bottom{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;padding:28px 40px 36px}
.project-window-bottom p{font:400 20px/1.7 var(--display)}
.project-window-bottom .button{font-size:13px;min-height:46px;padding:10px 18px}
.project-pagination{display:grid;grid-template-columns:minmax(0,1fr) auto minmax(0,1fr);align-items:center;gap:12px;flex:none;padding:10px 24px;border-top:1px solid var(--border);background:var(--bg)}
.project-pagination button{justify-self:start;min-height:44px;padding:8px 12px;border-radius:8px;background:transparent;color:var(--fg);font:400 13px/1.8 var(--body);transition:background 180ms}
.project-pagination button:last-child{justify-self:end}
.project-pagination button:hover:not(:disabled){background:var(--surface);color:var(--fg)}
.project-pagination button:disabled{opacity:.35}
.project-pagination>span{font-size:12px;color:var(--muted);direction:ltr}
.case-dialog{width:min(1240px,calc(100% - 40px));height:calc(100dvh - 40px);max-height:calc(100dvh - 40px);border-radius:20px}
.case-scroll{min-height:0}
.case-study .cs-hero{display:grid;grid-template-columns:minmax(0,1.5fr) minmax(0,1fr);gap:40px;align-items:end;padding-block:40px 32px}
.case-study .cs-title{font:500 clamp(36px,4.6vw,60px)/1.45 var(--display)}
.case-study .cs-lead{font-size:15px;margin-top:12px;line-height:1.95;text-wrap:pretty}
.case-study .meta{display:grid;gap:12px;margin:0;padding:0 24px 0 0;border-inline-start:1px solid var(--border)}
.case-study .meta li{grid-template-columns:70px minmax(0,1fr);gap:12px;align-items:baseline}
.case-study .meta .v{font:400 13px/1.8 var(--body)}
.case-study .cover{width:calc(100% - 48px);margin:0 auto;border:0;border-radius:14px;overflow:hidden;background:var(--surface)}
.case-study .cover figcaption{padding:10px 16px;border:0;background:var(--surface);color:var(--muted);font-size:12px}
.case-study .fig:hover{border-color:var(--fg);box-shadow:none}
.preview-dialog[open],.case-dialog[open]{animation:project-window-enter 300ms cubic-bezier(.2,.65,.3,1) both}
.preview-dialog[open]::backdrop,.case-dialog[open]::backdrop{animation:project-backdrop-enter 250ms ease both}
.preview-dialog[open] .project-intro,.case-dialog[open] .cs-hero{animation:project-content-enter 400ms 70ms both}
.preview-dialog[open] .project-showcase,.case-dialog[open] .cover{animation:project-content-enter 450ms 120ms both}
@keyframes project-window-enter{from{opacity:0;transform:translateY(20px) scale(.985)}to{opacity:1;transform:none}}
@keyframes project-content-enter{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}
@keyframes project-backdrop-enter{from{opacity:0}to{opacity:1}}
@media(max-width:899px){
 .portfolio-grid{gap:16px}.portfolio-grid .project-copy{padding:16px;gap:10px}.portfolio-grid .project-name{font-size:19px}.portfolio-grid .project-description{font-size:12px}
 .portfolio-grid .project-card:not(.featured-project) .project-copy{grid-template-columns:minmax(0,1fr) 36px}.portfolio-grid .project-arrow{width:36px;height:36px}
 .portfolio-grid .featured-project{grid-template-columns:minmax(0,1.5fr) minmax(0,1fr)}.portfolio-grid .featured-project .project-copy{padding:24px}.portfolio-grid .featured-project .project-visual{min-height:290px}
 .case-study .cs-hero{grid-template-columns:minmax(0,1fr);gap:24px}.case-study .meta{border:0;padding:0;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}.case-study .meta li{grid-template-columns:minmax(0,1fr);gap:4px}
}
@media(max-width:759px){
 .portfolio-grid{grid-template-columns:minmax(0,1fr);gap:20px}.portfolio-grid .project-card:not(.featured-project) .project-copy{grid-template-columns:minmax(0,1fr) 40px;padding:20px}.portfolio-grid .project-name{font-size:21px}.portfolio-grid .project-description{font-size:13px}.portfolio-grid .project-card:not(.featured-project) .project-description{min-height:0}
 .portfolio-grid .featured-project{display:flex;flex-direction:column}.portfolio-grid .featured-project .project-visual{aspect-ratio:16/9;min-height:0}.portfolio-grid .featured-project .project-image{position:static}.portfolio-grid .featured-project .project-copy{display:flex;align-items:flex-start;padding:24px}.portfolio-grid .featured-project .project-category{display:block;margin-bottom:8px}.portfolio-grid .featured-project .project-action{margin-top:18px}
 .preview-dialog,.case-dialog{width:calc(100% - 16px);height:calc(100dvh - 16px);max-height:calc(100dvh - 16px);border-radius:16px}
 .project-window-bar,.case-bar{padding:10px 16px}.project-intro{grid-template-columns:minmax(0,1fr);gap:8px;padding:24px}.project-intro>p{font-size:14px;padding:0}.project-showcase{margin-inline:12px;border-radius:8px}.project-window-bottom{padding:24px;gap:14px}.project-window-bottom p{font-size:18px}.project-pagination{padding:8px 12px;gap:4px}
 .case-study .container{width:calc(100% - 40px)}.case-study .cs-hero{padding-block:24px;gap:20px}.case-study .meta{grid-template-columns:minmax(0,1fr);gap:8px}.case-study .meta li{grid-template-columns:65px minmax(0,1fr);gap:12px}.case-study .cover{width:calc(100% - 24px);border-radius:8px}
}
@media(prefers-reduced-motion:reduce){.preview-dialog[open],.case-dialog[open],.preview-dialog[open]::backdrop,.case-dialog[open]::backdrop,.preview-dialog[open] .project-intro,.case-dialog[open] .cs-hero,.preview-dialog[open] .project-showcase,.case-dialog[open] .cover{animation:none}.portfolio-grid .project-image{transition:none}}
`;
d.head.append(style);
let output = dom.serialize();
output = output.replace("textDialog=document.getElementById('text-dialog'),", '');
output = output.replace(/^document\.querySelectorAll\('\[data-article\]'\).*\r?\n/m, '');
const oldProjectHandler = /^document\.querySelectorAll\('\[data-project\]'\).*\r?\n/m;
if (!oldProjectHandler.test(output)) throw new Error('Project handler not found');
output = output.replace(oldProjectHandler, `const projectButtons=[...document.querySelectorAll('[data-project]')];
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
`);
fs.writeFileSync(file, output);
console.log('Updated portfolio, project dialogs, about CTA and removed articles. Backup:', backup);
