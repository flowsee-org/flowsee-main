# Felosi — extracted design system

Source: supplied Figma file QqswYx2bEhsaDdIxkf5Sn9, standalone Home Page frame 1032:1103.

White canvas, orange and deep blue service cards, Persian display lettering, and a restrained 1,120px grid.

## Tokens

```css
:root {
  --bg: oklch(100.0000% 0 0);
  --surface: oklch(96.1151% 0 0);
  --fg: oklch(21.7787% 0 0);
  --muted: oklch(42.0237% 0 0);
  --border: oklch(92.4940% 0 0);
  --accent: oklch(67.3204% 0.21731 38.649);
  --blue: oklch(44.1127% 0.06906 233.606);
  --blue-deep: oklch(33.8445% 0.05014 231.981);
  --blue-light: oklch(85.1015% 0.04397 231.036);
  --blue-pale: oklch(92.6769% 0.02113 227.535);
  --grid: oklch(39.9918% 0.03891 261.488);
}
```

Original Figma color values: bg #FFFFFF, surface #F2F2F2, fg #1A1A1A, muted #4D4D4D, border #E6E6E6, accent #FE5400, blue #265973, blue-deep #193C4D, blue-light #B2D4E6, blue-pale #D9EAF2, grid #3C485D. OKLCH values are mathematical conversions.

## Typography

- Display: PARADOX, IRANSansX, sans-serif
- Body: IRANSansXFaNum, IRANSansX, sans-serif
- Navigation: IRANSansX Medium
- Latin labels: Montserrat Regular
- Mono: Consolas, monospace (utility fallback; not present in source)
- Exact installed font files copied into assets/fonts. Existing font rights apply.

## Observed rules

1. RTL content with left-aligned uppercase English section labels.
2. Desktop frame 1440px, content 1120px, 32px grid gaps.
3. Service and project cards have 16px corners; buttons 8px.
4. Original vector typography, translucent service emblems, iridescent hero art, and footer mascot are preserved.
5. Source orange/white small text does not meet 4.5:1; live small labels use darker orange on light surfaces and dark text on primary buttons. Original artwork remains unchanged.

## Responsive adaptation

Refined UI: services use three columns above 899px, two from 480–899px, and one below 480px. Portfolio uses one featured full-width project followed by two projects; below 650px all projects stack. Hero stacks below 650px; navigation collapses below 900px. Content images retain their complete natural frame.

## Source limitations retained

The Figma source repeats three portfolio images and one article. The refined homepage presents each once. The article uses a text-led layout instead of unsupplied cover imagery. Unconfigured social controls have been removed. No live contact endpoint or complete article was supplied; the brief form downloads a local draft and never claims to send it.

## UI refinement — requested by user

- White background, original orange/blue tokens, PARADOX and IRANSansX fonts retained.
- Original iridescent sculpture becomes the hero artwork.
- Distinct portfolio, service, about, and editorial sections; duplicate entries removed.
- Service selection opens the brief directly; email is optional.
- Primary project action is in the hero and repeated once at the end.
- Pre-change page preserved in felosi-home-v2.html.
