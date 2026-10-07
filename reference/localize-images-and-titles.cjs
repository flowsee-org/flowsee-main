const fs=require('fs');
const {JSDOM,VirtualConsole}=require('./qa/node_modules/jsdom');
const sharp=require('C:/Users/See/AppData/Local/Programs/Open Design/resources/app/node_modules/sharp');
const file='felosi-home-before-about-v2.html';
async function main(){
  let html=fs.readFileSync(file,'utf8');
  const d=new JSDOM(html,{virtualConsole:new VirtualConsole()}).window.document;
  const names={shopero:'شاپرو',ima:'ایما موویز',exloot:'اکسلوت',ebrahimi:'ابراهیمی'};
  for(const card of d.querySelectorAll('.project-card')){
    const before=card.outerHTML,key=card.dataset.project||card.dataset.case;
    const name=card.querySelector('.project-name'),english=name.textContent;
    name.outerHTML=`<span class="project-title-stack" data-od-id="project-title-${key}"><span class="project-name" lang="fa" dir="rtl">${names[key]}</span><span class="project-name-en" lang="en" dir="ltr">${english}</span></span>`;
    card.setAttribute('aria-label',key==='ebrahimi'?'نمایش کیس‌استادی ابراهیمی':'نمایش پروژهٔ '+names[key]);
    if(!html.includes(before))throw Error('Card source mismatch '+key);
    html=html.replace(before,card.outerHTML);
  }
  const previewTitle=d.querySelector('#preview-title');
  html=html.replace(previewTitle.outerHTML,`<div class="preview-title-stack">${previewTitle.outerHTML}<p id="preview-title-en" class="project-name-en" lang="en" dir="ltr"></p></div>`);
  html=html.replace("document.getElementById('preview-title').textContent=p.name;","document.getElementById('preview-title').textContent=b.querySelector('.project-name').textContent;document.getElementById('preview-title-en').textContent=p.name;");
  const css=`
/* Separate script directions and hierarchies; never mix names on one line. */
.portfolio-grid .project-title-stack{display:grid;gap:5px;width:100%;min-width:0;grid-column:1/-1}
.portfolio-grid .project-name{font-family:var(--display);font-size:21px;line-height:1.7;direction:rtl;text-align:right;unicode-bidi:isolate}
.project-name-en{display:block;width:100%;font-family:var(--latin);font-size:11px;font-weight:400;line-height:1.6;letter-spacing:.06em;text-align:left;direction:ltr;unicode-bidi:isolate;color:var(--muted)}
.portfolio-grid .featured-project .project-name-en{color:oklch(from var(--bg) 76% 0 0)}
.portfolio-grid .project-description{margin-top:8px}
.preview-title-stack{display:grid;gap:6px;min-width:0;flex:1}
.preview-dialog .preview-title-stack h2{font-family:var(--display);font-size:22px;line-height:1.7;text-align:right}
.preview-title-stack .project-name-en{margin:0}
.service-row .service-icon img{filter:brightness(0);opacity:.85}
.service-row:hover .service-icon img,.service-row:focus-visible .service-icon img{filter:brightness(0) invert(1);opacity:1}
@media(max-width:649px){.portfolio-grid .project-name{font-size:20px}.portfolio-grid .featured-project .project-title-stack{grid-column:1/-1;grid-row:1}}
`;
  const index=html.lastIndexOf('</style>');html=html.slice(0,index)+css+html.slice(index);
  const allSources=[...new Set([...d.querySelectorAll('img[src]')].map(img=>img.getAttribute('src')).filter(src=>!src.startsWith('data:')))];
  const replacements=new Map();let originalBytes=0,embeddedBytes=0;
  for(const source of allSources){
    if(!fs.existsSync(source))throw Error('Missing image '+source);
    const original=fs.readFileSync(source);originalBytes+=original.length;
    const meta=await sharp(original).metadata();
    let data,mime;
    if(source.endsWith('.svg')){data=original;mime='image/svg+xml'}
    else{data=await sharp(original).webp({quality:90,alphaQuality:100,effort:5}).toBuffer();mime='image/webp'}
    embeddedBytes+=data.length;
    replacements.set(source,{url:`data:${mime};base64,${data.toString('base64')}`,width:meta.width,height:meta.height});
  }
  html=html.replace(/<img\b[^>]*>/g,tag=>{
    const source=tag.match(/\bsrc="([^"]+)"/)?.[1];if(!source||!replacements.has(source))return tag;
    const image=replacements.get(source);
    tag=tag.replace(`src="${source}"`,`data-asset-source="${source}" src="${image.url}"`);
    tag=tag.replace(/\bwidth="[^"]*"/,`width="${image.width}"`).replace(/\bheight="[^"]*"/,`height="${image.height}"`);
    return tag;
  });
  // The lightbox uses the thumbnail's embedded source. No host URL is reconstructed.
  const backup='reference/felosi-before-embedded-images-v2.html';if(!fs.existsSync(backup))fs.copyFileSync(file,backup);
  fs.writeFileSync(file,html,'utf8');
  fs.writeFileSync('reference/embedded-image-audit.json',JSON.stringify({count:allSources.length,originalBytes,embeddedBytes,htmlBytes:Buffer.byteLength(html),images:[...replacements].map(([source,entry])=>({source,width:entry.width,height:entry.height}))},null,2));
  console.log(JSON.stringify({images:allSources.length,originalBytes,embeddedBytes,htmlBytes:Buffer.byteLength(html)}));
}
main().catch(error=>{console.error(error);process.exitCode=1});
