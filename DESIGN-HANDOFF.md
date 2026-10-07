# 9b8f7775-9c9d-441a-966a-b65c3061b940 implementation handoff

This archive is the source of truth for turning the design into production code. Start from `ebrahimi-case-study.html`, then preserve the visual system, responsive behavior, and interactions found in the exported files.

## Implementation target
- Build production UI from the exported design, not a loose reinterpretation.
- Preserve typography scale, spacing rhythm, color tokens, border radii, shadows, motion timing, and component states.
- Replace static placeholders only when the target app has real data or functional equivalents.
- Keep generated product UI free of OpenDesign chrome, preview labels, or design-process annotations.
- Treat this handoff as a visual contract: if implementation choices conflict, match the exported pixels and behavior first, then refactor internals.

## Source map
- Primary entry: `ebrahimi-case-study.html`
- HTML screens detected: 7
- Stylesheets detected: 0
- Script/component files detected: 13
- Supporting assets detected: 115

## Responsive contract
Validate the implementation across this 2025–2026 viewport matrix:
- Mobile compact: 360×800
- Mobile standard: 390×844
- Mobile large: 430×932
- Foldable / small tablet: 600×960
- Tablet portrait: 820×1180
- Tablet landscape: 1024×768
- Laptop: 1366×768
- Desktop: 1440×900
- Wide desktop: 1920×1080

For responsive web exports, treat these as a modern breakpoint system for one adaptive web experience, not three fixed screenshots. Do not split responsive web into unrelated native app screens unless the project explicitly includes native targets. Use semantic layout thresholds, fluid `clamp()` type/spacing, and container queries where component width matters more than viewport width. Preserve any CSS media queries, container queries, fluid `clamp()` scales, and layout changes already present in the exported files.

## Design fidelity contract
- Extract reusable tokens before writing components: background, surface, foreground, muted text, border, accent, radius, shadow, spacing, type scale, and motion duration/easing.
- Map product screens, in-app modules/components, optional landing page, and optional OS widget surfaces before coding. Keep these surfaces separate in the target architecture.
- Match layout geometry: max-widths, gutters, grid columns, card proportions, sticky/fixed elements, and viewport-specific navigation.
- Preserve real copy, labels, and data shown in the export. Do not replace specific text with generic marketing filler.
- Preserve interactive affordances: hover, focus, pressed, disabled, loading, validation, copy/share, tab/accordion, modal/sheet, and keyboard states where present.
- Preserve accessibility semantics when converting: headings stay hierarchical, controls remain buttons/links/inputs, focus states stay visible.
- Do not keep prototype-only annotations, frame labels, or OpenDesign chrome in the production UI.

## CJX-ready UX contract
- Use `DESIGN-MANIFEST.json` as the machine-readable map for screens, app modules, OS widgets, landing pages, tokens, interactions, and viewport checks.
- Screen-file-first: when multiple user-facing surfaces exist, implement each HTML screen as its own route/file. Treat `index.html` as a launcher/overview when the manifest marks it that way, not as a combined final UI.
- If `landing.html`, app screens, platform screens, or OS widget files exist, preserve those boundaries in the target app instead of merging them into one page.
- A single self-contained `ebrahimi-case-study.html` is acceptable only when the export truly contains one user-facing screen and its CSS/JS are structured enough to extract tokens, components, states, and behavior.
- If separate `css/` or `js/` files exist, treat them as source of truth for token/component/interactions before porting to React, Vue, SwiftUI, Compose, or another target stack.
- In-app modules/components are product UI blocks inside the app. OS widgets are home-screen/lock-screen/quick-access surfaces outside the app. Do not merge those concepts.

## Color and brand contract
- Use the exported design tokens and product/domain context as the color source of truth.
- Do not introduce warm beige / cream / peach / pink / orange-brown background washes unless they are already explicit brand/reference colors in the export.
- No obvious token stylesheet was detected; sample colors from the entry file and convert them into named tokens before coding.

## Implementation sequence for AI coding tools
1. Open `ebrahimi-case-study.html` and `DESIGN-MANIFEST.json`; identify every screen file, launcher/overview file, app module, and interaction before coding.
2. If multiple HTML screens exist, map them to separate routes/surfaces first; do not merge `landing.html`, product app screens, platform screens, or OS widgets into one route.
3. Extract a token table from CSS/root styles and inline styles before building framework components.
4. Build product screens and domain-specific in-app modules from largest layout regions down to controls; avoid starting with isolated atoms that lose spatial intent.
5. Port responsive behavior across the modern viewport matrix and test each semantic breakpoint before cleanup.
6. Port interactions and states, then replace static placeholders only with real app data or functional equivalents.
7. Keep optional landing page and OS widget surfaces as separate surfaces if present.
8. Compare final screenshots against the export at 360×800, 390×844, 430×932, 820×1180, 1024×768, 1366×768, 1440×900, and 1920×1080 before declaring done.

## Entry points
- `ebrahimi-case-study.html`
- `felosi-home-before-about-v2.html`
- `felosi-home-v2.html`
- `felosi-home.html`
- `reference/felosi-before-contact-v2.html`
- `reference/felosi-before-embedded-images-v2.html`
- `reference/felosi-before-portfolio-redesign-v2.html`

## Styles
- None detected

## Scripts/components
- `reference/build-page.mjs`
- `reference/finish-refinement.cjs`
- `reference/localize-assets.mjs`
- `reference/localize-images-and-titles.cjs`
- `reference/optimize-embedded-images.cjs`
- `reference/refine-about-portfolio.cjs`
- `reference/refine-contact-experience.cjs`
- `reference/refine-gallery-validation.cjs`
- `reference/refine-portfolio-presentation.cjs`
- `reference/refine-ui.cjs`
- `reference/verify-contact-experience.cjs`
- `reference/verify-page.cjs`
- `reference/verify-style-repair.cjs`

## Assets and supporting files
- `01.jpg`
- `02.jpg`
- `03.jpg`
- `04.jpg`
- `05.jpg`
- `06.jpg`
- `07.jpg`
- `08.jpg`
- `09.jpg`
- `10.jpg`
- `11.jpg`
- `12.jpg`
- `13.jpg`
- `14.jpg`
- `15.jpg`
- `16.jpg`
- `17.jpg`
- `18.jpg`
- `19.jpg`
- `20.jpg`
- `21.jpg`
- `22.jpg`
- `23.jpg`
- `24.jpg`
- `25.jpg`
- `26.jpg`
- `27.jpg`
- `28.jpg`
- `29.jpg`
- `30.jpg`
- `31.jpg`
- `32.jpg`
- `33.jpg`
- `34.jpg`
- `35.jpg`
- `assets/blog-card-img169.svg`
- `assets/blog-card-img170.svg`
- `assets/blog-card-imgVuesaxOutlineClock.svg`
- `assets/felosi-logo-sculpture.png`
- `assets/fonts/IRANSansX-Medium.ttf`
- `assets/fonts/IRANSansX-Regular.ttf`
- `assets/fonts/IRANSansXFaNum-Regular.ttf`
- `assets/fonts/Montserrat-Regular.ttf`
- `assets/fonts/PARADOX-Regular.ttf`
- `assets/footer-imgEllipse1.svg`
- `assets/footer-imgEllipse2.svg`
- `assets/footer-imgEllipse3.svg`
- `assets/footer-imgEllipse4.svg`
- `assets/footer-imgEllipse5.svg`
- `assets/footer-imgGmail.svg`
- `assets/footer-imgGmail1.svg`
- `assets/footer-imgInstagram.svg`
- `assets/footer-imgInstagram1.svg`
- `assets/footer-imgTelegram.svg`
- `assets/footer-imgTelegram1.svg`
- `assets/footer-imgUnion.svg`
- `assets/footer-imgWhatsapp.svg`
- `assets/footer-imgWhatsapp1.svg`
- `assets/header-imgFrame17.svg`
- `assets/hero-imgImage6.png`
- `assets/hero-imgTitle.svg`
- `assets/hero-imgTitle1.svg`
- `assets/intro-imgBg.png`
- `assets/mascot-imgMascut.svg`
- `assets/portfolio-imgExloot2.png`
- `assets/portfolio-imgIma2.png`
- `assets/portfolio-imgShopero1.png`
- `assets/services-img.svg`
- `assets/services-img1.svg`
- `assets/services-img2.svg`
- `assets/services-img3.svg`
- `assets/services-img4.svg`
- `assets/services-img5.svg`
- `assets/services-img52837428315365567501.svg`
- `assets/services-imgAcademyIconContainer.svg`
- `assets/services-imgIconPrint.svg`
- `assets/services-imgIconUiux.svg`
- `assets/services-imgMarketingIconContainer.svg`
- `assets/services-imgServiceDescriptionText.svg`
- `assets/services-imgServiceDescriptionText1.svg`
- `assets/services-imgServiceDescriptionText2.svg`
- `assets/services-imgServiceDescriptionText3.svg`
- `assets/services-imgServiceDescriptionText4.svg`
- `assets/services-imgServiceDescriptionText5.svg`
- `assets/services-imgUnionIconGroup.svg`
- `assets/services-imgVideoIconContainer.svg`
- `brand-spec.md`
- `image-1.png`
- `image.png`
- `reference/asset-manifest.json`
- `reference/blog-card.txt`
- `reference/blog-heading.txt`
- `reference/blog.txt`
- `reference/embedded-image-audit.json`
- `reference/felosi-logo-reference.png`
- `reference/felosi-preview.png`
- `reference/felosi-sculpture-prompt.md`
- `reference/felosi-ui-refined.png`
- `reference/figma-home.png`
- `reference/final-image-check.json`
- `reference/footer.txt`
- `reference/header.txt`
- `reference/hero.txt`
- `reference/intro.txt`
- `reference/mascot.txt`
- `reference/portfolio.txt`
- `reference/qa/ebraimi-case-study.png`
- `reference/qa/felosi-about-portfolio.png`
- `reference/qa/felosi-compact-type.png`
- `reference/qa/felosi-contact-refined.png`
- `reference/qa/felosi-persian-projects.png`
- `reference/qa/felosi-portfolio-redesigned.png`
- `reference/qa/package.json`
- `reference/services.txt`
- `reference/verification.json`

## Coding checklist for AI tools
1. Inspect `ebrahimi-case-study.html` and `DESIGN-MANIFEST.json` first and identify reusable components before coding.
2. Implement each user-facing screen file as its own route/surface; keep launcher, landing, app, platform, and OS widget files separate.
3. Extract design tokens into the target stack: colors, type scale, spacing, radius, shadows, and motion.
4. Implement layout with real 2025–2026 responsive breakpoints, fluid type/spacing, and container-query-aware component behavior; test with no horizontal overflow.
5. Preserve interactive controls, hover/focus/pressed states, form behavior, validation, and copy actions where present.
6. Implement domain-specific in-app modules with real states; do not flatten them into generic cards.
7. Keep landing page, product screens, and OS widget/quick-access surfaces separate when present.
8. Confirm the production result visually matches the exported design before refactoring internals.
9. Reject implementation shortcuts that flatten the design into generic cards, generic gradients, placeholder stats, or framework-default typography.
10. If a detail is ambiguous, keep the exported HTML/CSS/JS behavior rather than inventing a new pattern.
