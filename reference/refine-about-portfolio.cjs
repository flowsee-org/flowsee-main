const fs = require('fs');
const { JSDOM, VirtualConsole } = require('./qa/node_modules/jsdom');
const file = 'felosi-home.html';
let html = fs.readFileSync(file, 'utf8');
const dom = new JSDOM(html, { virtualConsole: new VirtualConsole() });
const doc = dom.window.document;
const grid = doc.querySelector('.portfolio-grid');
const originalGrid = grid.outerHTML;
const descriptions = {
  shopero: 'طراحی فروشگاه آنلاین',
  ima: 'طراحی پلتفرم ویدیو',
  exloot: 'طراحی بازار دیجیتال',
  ebrahimi: 'طراحی هویت بصری'
};
for (const card of grid.children) {
  const key = card.dataset.project || card.dataset.case;
  card.querySelector('.project-description').textContent = descriptions[key];
  const image = card.querySelector('img');
  image.alt = image.alt.replace('نمای کامل پروژه', 'نمای پروژه');
}
grid.prepend(grid.querySelector('[data-case="ebrahimi"]'));
html = html.replace(originalGrid, grid.outerHTML);
const oldAbout = doc.querySelector('#about').outerHTML;
const newAbout = `<section class="studio-about" id="about" aria-labelledby="about-title" data-od-id="about">
  <div class="studio-intro" data-od-id="about-introduction">
    <div class="studio-heading"><span class="eyebrow">دربارهٔ استودیو</span><h2 id="about-title" data-od-id="about-title">خلاقیت در<br>دنیای دیجیتال.</h2></div>
    <div class="studio-copy"><p data-od-id="about-description">در فلوسی، هویت بصری، تجربه‌های دیجیتال و محتوای برند را طراحی می‌کنیم. از تعریف مسیر تا اجرای جزئیات، طراحی را با نیاز کسب‌وکار شما هماهنگ می‌کنیم.</p><a class="quiet-link" href="tel:+989109027628" data-od-id="about-phone">مشاورهٔ تلفنی <span dir="ltr">۰۹۱۰۹۰۲۷۶۲۸</span><svg class="icon" aria-hidden="true"><use href="#i-phone"></use></svg></a></div>
  </div>
  <ul class="studio-principles" aria-label="ارزش‌های استودیو" data-od-id="about-values">
    <li data-od-id="about-value-innovation"><span class="studio-number" aria-hidden="true">۰۱</span><h3>نوآوری</h3><p>ایده‌هایی که از کلیشه فاصله می‌گیرند.</p></li>
    <li data-od-id="about-value-precision"><span class="studio-number" aria-hidden="true">۰۲</span><h3>دقت</h3><p>جزئیاتی که کیفیت را می‌سازند.</p></li>
    <li data-od-id="about-value-growth"><span class="studio-number" aria-hidden="true">۰۳</span><h3>رشد</h3><p>طراحی در خدمت نتیجهٔ کسب‌وکار.</p></li>
  </ul>
</section>`;
if (!html.includes(oldAbout) || !html.includes(grid.outerHTML)) throw Error('Section replacement failed');
html = html.replace(oldAbout, newAbout);
const css = `
/* Full-bleed portfolio images: cropping is intentional in cards only. */
.portfolio-grid .project-visual{display:block;position:relative;flex:0 0 auto;aspect-ratio:16/9;background:var(--surface);overflow:hidden}
.portfolio-grid .project-image{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center}
.portfolio-grid .featured-project .project-visual{aspect-ratio:auto;min-height:clamp(280px,30vw,420px)}
.portfolio-grid .project-card:not(.featured-project) .project-description{min-height:1.85em}
/* About: an open editorial layout with a shared baseline for studio principles. */
.studio-about{border-block:1px solid var(--border);padding-block:40px;background:var(--bg);color:var(--fg)}
.studio-intro{display:grid;grid-template-columns:minmax(0,.85fr) minmax(0,1.15fr);gap:64px;align-items:start}
.studio-heading .eyebrow{margin-bottom:12px}
.studio-heading h2{font-family:var(--display);font-size:clamp(28px,2.8vw,38px);font-weight:400;line-height:1.65;text-wrap:balance}
.studio-copy{padding-top:8px;min-width:0}
.studio-copy p{font-size:16px;line-height:2;max-width:56ch;text-wrap:pretty;color:var(--muted)}
.studio-copy .quiet-link{margin-top:16px;gap:12px;font-size:13px;flex-wrap:wrap;justify-content:flex-start}
.studio-copy .quiet-link span{font:inherit}
.studio-principles{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:32px;list-style:none;padding:28px 0 0;margin:32px 0 0;border-top:1px solid var(--border)}
.studio-principles li{display:grid;grid-template-columns:28px minmax(0,1fr);gap:8px 12px;align-content:start}
.studio-number{font-size:12px;line-height:32px;color:var(--accent-ink)}
.studio-principles h3{font-family:var(--display);font-size:20px;font-weight:500;line-height:1.6}
.studio-principles p{grid-column:2;font-size:13px;line-height:1.9;color:var(--muted);text-wrap:pretty}
@media(max-width:899px){
  .studio-intro{gap:32px;grid-template-columns:minmax(0,.8fr) minmax(0,1.2fr)}
  .studio-copy p{font-size:15px}
  .studio-principles{gap:20px}
  .studio-principles li{grid-template-columns:20px minmax(0,1fr);gap:8px}
}
@media(max-width:649px){
  .portfolio-grid .featured-project .project-visual{aspect-ratio:16/9;min-height:0}
  .studio-about{padding-block:28px}
  .studio-intro{grid-template-columns:minmax(0,1fr);gap:20px}
  .studio-heading h2 br{display:none}
  .studio-copy{padding-top:0}
  .studio-copy p{font-size:14px;line-height:1.95}
  .studio-principles{grid-template-columns:minmax(0,1fr);gap:0;padding-top:0;margin-top:24px}
  .studio-principles li{grid-template-columns:28px minmax(0,1fr);gap:4px 12px;padding-block:20px;border-bottom:1px solid var(--border)}
  .studio-principles li:last-child{padding-bottom:0;border-bottom:0}
  .studio-principles h3{font-size:18px}
}
`;
const styleEnd = html.lastIndexOf('</style>');
if (styleEnd < 0) throw Error('No style insertion point');
html = html.slice(0, styleEnd) + css + html.slice(styleEnd);
const backup = 'felosi-home-before-about-v2.html';
if (!fs.existsSync(backup)) fs.copyFileSync(file, backup);
fs.writeFileSync(file, html, 'utf8');
dom.window.close();
console.log('Updated about section, project ordering, descriptions and image fill.');
