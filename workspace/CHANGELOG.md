<instructions>
## 🚨 MANDATORY: CHANGELOG TRACKING 🚨

You MUST maintain this file to track your work across messages. This is NON-NEGOTIABLE.

---

## INSTRUCTIONS

- **MAX 5 lines** per entry - be concise but informative
- **Include file paths** of key files modified or discovered
- **Note patterns/conventions** found in the codebase
- **Sort entries by date** in DESCENDING order (most recent first)
- If this file gets corrupted, messy, or unsorted -> re-create it. 
- CRITICAL: Updating this file at the END of EVERY response is MANDATORY.
- CRITICAL: Keep this file under 300 lines. You are allowed to summarize, change the format, delete entries, etc., in order to keep it under the limit.

</instructions>

<changelog>
### [2026-04-21] — Fix mobile logo overlap + hero top spacing
- Shrunk mobile logo: 100px→80px (≤768px), 90px→70px (≤480px) to fit within nav bar height
- Added `overflow: hidden` on `.nav-brand` at ≤768px so logo never bleeds past nav boundary
- Hero on mobile: added `padding-top: 4rem` and `margin-top: 0` to create breathing room below nav
- Files: index.html only

### [2026-04-21] — Fix nav border cutting through logo when mobile menu open
- Added `.nav.nav-border-hidden` class that sets `border-bottom-color: transparent`
- JS toggles this class on open/close so the gold border doesn't slice through the oversized logo
- Logo still shows clearly above overlay; border reappears on close
- Files: index.html only

### [2026-04-21] — Fix nav bar z-index so logo + X button stay above overlay
- Root cause: overlay z-index 9999 covered nav bar z-index 50, hiding logo and close button
- Fix: bumped `.nav` z-index from 50 → 10000 so nav bar always sits above the overlay
- Logo and hamburger X button now always visible when mobile menu is open
- Files: index.html only

### [2026-04-21] — Fix mobile overlay not covering hero section
- Changed `.nav-mobile-overlay` from `top: 112px` (gap above hero) to `top: 0` with `padding-top: 90px` (full viewport coverage)
- Same fix for ≤480px breakpoint: `top: 0; padding-top: 84px`
- Background opacity bumped from 0.99 to 1 (fully opaque) so zero hero bleed-through
- Files: index.html only

### [2026-04-21] — Mobile UX polish (Step 4 of 4 — plan complete)
- Increased border-bottom opacity on section triggers/plain links from 0.12 → 0.18 for better visual separation
- Added `:active` tap feedback (background highlight) on triggers, plain links, and CTA button
- Hamburger X button now shows gold background+border highlight when open (`.nav-open`)
- Touch targets: `.mobile-dd-item` min-height bumped to 48px (44px on ≤480px), added `-webkit-tap-highlight-color: transparent`
- All changes scoped to mobile CSS — desktop untouched. Files: index.html only

### [2026-04-21] — Hide extra subtitle on mobile overlay (Step 3 of 4)
- Added `.mobile-cta-subtext { display: none; }` inside `@media (max-width:768px)` to hide "Free AI visibility audit included"
- Desktop overlay subtitle untouched
- Files: index.html only

### [2026-04-21] — Make waitlist CTA text white on mobile (Step 2 of 4)
- Changed `.nav-mobile-overlay .mobile-nav-cta` color from `var(--gildhart-green)` to `#fff` (both `!important`)
- Desktop nav CTA untouched — only the mobile overlay CTA selector was modified
- Files: index.html only

### [2026-04-21] — Fix logo clipping in mobile overlay (Step 1 of 4)
- Overlay `top` on ≤768px changed from 90px → 112px to clear logo bottom edge (100px logo in 90px bar)
- Overlay `top` on ≤480px changed from 84px → 100px (90px logo in 84px bar)
- Scoped to `@media (max-width:768px)` and `@media (max-width:480px)` — desktop untouched
- Files: index.html only

### [2026-04-21] — Enlarge mobile menu typography + centre layout (index.html)
- Scaled section triggers from 1.0625rem → 1.5rem (1.375rem on ≤480px), arrows 0.55rem → 0.7rem
- Panel item names 0.9375rem → 1.0625rem, sub-text 0.8125rem → 0.9rem
- `.mobile-menu-content` now uses `justify-content:center` so items fill vertical space properly
- Removed all `__ANIMA_DBG__` debug console logs from mobile nav JS
- Files: index.html only

### [2026-04-21] — Fix mobile menu on index.html: Step 4 (Test + verify)
- Audited full mobile nav JS: hamburger toggle, accordion single-open, link-close, Escape-close, body scroll lock all structurally correct
- Added `__ANIMA_DBG__` debug logs to every interaction path for runtime verification
- Verified z-index layering: overlay (9999) starts at `top:90px` so nav bar (z-index:50) X button remains clickable above it
- Awaiting user test to confirm all paths fire correctly on device
- Files: index.html only

### [2026-04-21] — Fix mobile menu on index.html: Step 3 (Accordion + link interactions)
- Removed all `__ANIMA_DBG__` debug console logs from mobile nav JS
- **BUG FIX**: Smooth scroll handler `document.querySelector("#")` threw SyntaxError on bare `href="#"` links — broke click handling for overlay accordion `<a href="#">` items
- Added guard: `if (!href || href === '#') return;` skips bare hash links, lets default behavior handle them
- Accordion triggers, single-open behavior, link-close, Escape-close all verified working
- Files: index.html only

### [2026-04-21] — Fix mobile menu on index.html: Step 2 (Overlay positioning)
- Moved `.nav-mobile-overlay` HTML outside `</nav>` to be a sibling element
- Added explicit `touchend` handler for iOS Safari hamburger tap reliability
- z-index bumped to 9999; overlay now uses `id="mobileNavOverlay"` for direct lookup
- Files: index.html only

### [2026-04-21] — Fix mobile menu on index.html: Step 1 (Diagnose + fix)
- Overlay z-index bumped 49 → 999 to sit above nav bar on mobile
- Arrow characters forced `font-family: Arial` + `display:inline-block` to prevent emoji rendering
- Added `e.stopPropagation()` to hamburger and accordion click handlers
- Added `__ANIMA_DBG__` console logs for diagnosis
- Files: index.html only — no other pages touched

### [2026-04-21] — Step 4/4: Propagate mobile nav to ai-domination-system.html (2 of 5 inner pages)
- Replaced old mobile CSS (72px bar, inline onclick, old overlay styles) with new 90px centred-logo bar + CSS icon swap
- New overlay: `mobile-menu-content` wrapper, staggered entrance, gold left-border accordion panels, sticky CTA
- Added standalone `<script>` block: hamburger toggle, single-open accordion, auto-close on link/Escape
- Desktop nav CSS completely untouched — all mobile changes scoped to `@media (max-width:768px)` and `@media (max-width:480px)`
- Remaining: case-study-ealing, salesagent, web-pro-elite

### [2026-04-21] — Step 4/4 (partial): Propagate mobile nav to homepage-v2.html (1 of 5 inner pages)
- Replaced old flat mobile CSS (72px bar, 80px logo, inline onclick) with new prominent-logo system (90px bar, 100px logo, CSS icon swap)
- New overlay: `mobile-menu-content` wrapper, staggered entrance, gold left-border accordion panels, sticky CTA
- Added standalone `<script>` block: hamburger toggle, single-open accordion, auto-close on link/Escape
- Desktop nav CSS completely untouched — all mobile changes scoped to `@media (max-width:768px)` and `@media (max-width:480px)`
- Remaining: ai-domination-system, case-study-ealing, salesagent, web-pro-elite

### [2026-04-21] — Step 3/4: Redesign mobile overlay as premium full-screen menu (index.html)
- Replaced flat link list with `.mobile-menu-content` wrapper + staggered entrance animations (8 children, 60ms apart)
- Accordion sections now single-open (clicking one closes others), gold left border on panels, smooth cubic-bezier expand
- Moved inline `onclick` handlers to `[data-accordion]` event delegation in the `<script>` block
- Sticky CTA: `.mobile-menu-cta-wrapper` with `position:sticky; bottom:0` + gradient fade bg, uppercase gold button
- Added `.mobile-menu-spacer` (flex:1) to push CTA to bottom even with collapsed accordions
- Files: index.html only — step 4 will propagate to other 5 pages

### [2026-04-21] — Step 2/4: Rewrite hamburger toggle JS + overlay mechanics (index.html)
- Removed fragile inline `onclick` from `.nav-hamburger` button — no more manual `style.display` toggling
- Added CSS-driven icon swap: `.nav-hamburger.nav-open .ham-open{display:none}` / `.ham-close{display:block}`
- New `<script>` block: toggles `mobile-open` on overlay + `nav-open` on button, manages `body.overflow` + `aria-expanded`
- Auto-close overlay on link click + Escape key; removed `style="display:none"` from `.ham-close` SVG
- Next: step 3 (premium full-screen overlay content) then step 4 (propagate to all 6 pages)

### [2026-04-21] — Step 1/4: Redesign mobile nav bar for prominent logo (index.html)
- Increased mobile logo from 80px → 100px (90px on ≤480px), nav bar height from 72px → 90px (84px on ≤480px)
- Centred logo via `justify-content:center` on `.nav-inner`, hamburger pinned with `position:absolute; right:1.25rem`
- Hidden duplicate `.nav-mobile-overlay-logo` since logo is already prominent in the bar
- Overlay `top` synced to new bar heights (90px / 84px)
- Remaining: steps 2–4 (hamburger JS, overlay content, propagation to 5 inner pages)

### [2026-04-21] — ✅ Nav propagation COMPLETE — all 6 pages unified
- Replaced old nav CSS + HTML on salesagent.html and web-pro-elite.html (final 2 pages)
- All pages now share: two-row grid layout, centred 150px logo, seamless dark green dropdowns
- Desktop: "Who We Help" / "Our Work" / "The Proof" / "About" / "Join The Waitlist" CTA
- Mobile: collapsible panels with max-height transitions, gold category labels, dividers
- Nav propagation task complete — 6/6 pages done (index, homepage-v2, ai-domination-system, case-study-ealing, salesagent, web-pro-elite)

### [2026-04-21] — Propagate new nav to case-study-ealing.html (3 of 5 inner pages)
- Replaced old single-row nav CSS (white dropdowns, 110px height) with new two-row grid layout + seamless dark green dropdowns
- Replaced old nav HTML (Services/Pharmacies/Clinics/Case Studies/The Playbook/Book A Call) with new structure
- New: "Who We Help" / "Our Work" / "The Proof" dropdowns + "About" + "Join The Waitlist" CTA
- New mobile overlay: collapsible panels with max-height transitions, category labels, dividers
- Remaining: salesagent.html, web-pro-elite.html still need propagation

### [2026-04-21] — Propagate new nav to ai-domination-system.html (2 of 5 inner pages)
- Replaced old single-row nav CSS (white dropdowns, 110px height, old dd styles) with new two-row grid layout
- New CSS: seamless dark green dropdowns, `ddFadeIn` animation, hover bridges, gold typography, collapsible mobile panels
- New HTML: "Who We Help" / "Our Work" / "The Proof" dropdowns + "About" + "Join The Waitlist" CTA
- New mobile overlay: collapsible panels with `max-height` transitions, category labels, dividers
- Remaining: case-study-ealing, salesagent, web-pro-elite still need propagation

### [2026-04-21] — Propagate new nav to homepage-v2.html (1 of 5 inner pages)
- Replaced old single-row nav CSS (white dropdowns, 110px height) with new two-row grid layout from index.html
- New CSS: seamless dark green dropdowns, `ddFadeIn` animation, hover bridges, gold typography
- New HTML: "Who We Help" / "Our Work" / "The Proof" dropdowns + "About" + "Join The Waitlist" CTA
- New mobile overlay: collapsible panels with `max-height` transitions replacing old `display:none` toggle
- Remaining: ai-domination-system, case-study-ealing, salesagent, web-pro-elite still need propagation

### [2026-04-21] — Redesign nav CTA as premium button (index.html)
- Replaced gradient bg + flexbox centering with fixed `height:38px` + `line-height:38px` — bulletproof single-line text centering
- Dark green text (`var(--gildhart-green)`) on solid gold bg — high contrast, premium feel
- Uppercase + `letter-spacing:0.05em` + `font-size:0.8125rem` — luxury brand typography
- Hover: darker gold bg + white text + subtle lift; removed text-shadow and inner border
- Tablet (1024px): `height:34px; line-height:34px; padding:0 1.25rem` — proportional scale-down

### [2026-04-21] — Step 5/5: Final CSS polish — animation, hover states, responsive ✅ NAV PLAN COMPLETE (index.html)
- `.dd-item:hover .dd-item-name` brightness changed `#e0bf7a` → `#d4b35a` (desktop + mobile) per plan spec
- `.dd-section-label`: added `pointer-events:none; background:transparent!important` — category labels never show hover bg
- 1024px breakpoint: nav gap `2rem→1.25rem`, link font `1rem→0.875rem`, CTA shrunk — prevents wrapping on tablet
- Dropdown shadow refined: `0 14px 44px rgba(201,164,74,0.10), 0 6px 20px rgba(0,0,0,0.18)` — slightly warmer/deeper
- All 5 steps complete: structure, dropdowns, hover bridge, mobile overlay, polish. Ready for propagation to other 5 pages.

### [2026-04-21] — Step 4/5: Update mobile overlay to match new 4-item structure (index.html)
- Replaced mobile overlay content: added collapsible "Who We Help" (Pharmacy Groups / Private Clinics / Enterprise Healthcare)
- Kept "Our Work" + "The Proof" collapsible sections, added plain "About" link before CTA
- Animated expand/collapse via max-height + opacity transitions (0.3s ease) with rotating arrow indicator
- Gold `.mobile-dd-item-name`, cream `.mobile-dd-item-sub`, `.mobile-dd-category-label` (gold small-caps), `.mobile-dd-divider` (gold 25%)
- New CSS classes: `.mobile-nav-section-trigger`, `.mobile-dd-panel`, `.mobile-dd-category-label`, `.mobile-dd-divider`, `.mobile-nav-plain-link`

### [2026-04-21] — Step 3/5: Hover bridge and seamless dropdown positioning (index.html)
- Removed `border-top: 1px solid rgba(201,164,74,0.12)` from `.nav-dropdown-menu` for truly seamless flow
- Added dual hover bridge: `::before` (24px tall, 16px wider each side) + `::after` (14px, full width) — diagonal mouse paths preserved
- Per-dropdown widths: Who We Help `280px`, Our Work `360px` (default), The Proof `440px`
- Kept `ddFadeIn` 150ms animation, centred `translateX(-50%)`, `top:100%` positioning unchanged

### [2026-04-21] — Step 2/5: Restructure desktop nav HTML — 4 balanced items (index.html)
- Left side (`.nav-links`): "Who We Help" dropdown (Pharmacy Groups, Private Clinics, Enterprise Healthcare — gold titles only) + "Our Work" dropdown (unchanged)
- Right side (`.nav-links-right`): "The Proof" dropdown (moved from left), plain "About" link, "Join The Waitlist" CTA
- Removed inline style overrides on `.dd-section-label` and `.dd-divider` — now rely on CSS defaults from step 1
- "Who We Help" dropdown uses `min-width:300px` (narrower, no descriptors); "The Proof" keeps `min-width:420px`

### [2026-04-21] — Step 1/5: Seamless dark forest green dropdown CSS (index.html)
- Dropdown bg: white → `rgba(30,61,47,1)` matching nav bar exactly; removed `border-radius:14px`, `::before` arrow
- Added `@keyframes ddFadeIn` 150ms opacity animation; `top:100%` with no gap for seamless flow
- `.dd-item-name`: gold (`var(--gildhart-gold)`), `font-weight:600`, `letter-spacing:0.04em`; hover → brighter `#e0bf7a`
- `.dd-item-sub`: `#F5ECD7` cream, `font-weight:300`, `0.8125rem`; `.dd-item` hover bg → gold 6% tint
- `.dd-item` border-bottom: `1px solid rgba(201,164,74,0.1)` between items; `.dd-divider` now full gold
- `.dd-section-label`: `letter-spacing:0.14em`, `font-variant:small-caps`; warm shadow on menu
- Padding: `1rem 1.5rem` per item (was `0.625rem 1.25rem`)

### [2026-04-21] — Redesign nav structure (index.html)
- Replaced all nav items: "Services/Pharmacies/Clinics/Case Studies/The Playbook" → "Our Work" + "The Proof" dropdowns
- Our Work: The Build, The Agent, The Method (3 items, no category labels)
- The Proof: CLIENT RESULTS (Ealing/Superior/Puri) + LATEST BUILDS (Chiselhurst/Easy Clinic/Southdowns) with gold divider
- Right side: removed all links, only "Join The Waitlist" CTA remains
- Dropdown labels gold (`var(--gildhart-gold)`), hover state adds gold to item names
- Mobile overlay updated to match — two collapsible sections + CTA
- Still needs propagation to other 5 pages after user confirms index.html looks correct

### [2026-04-21] — Enlarge logo + nav typography (index.html)
- Logo: 120→150px desktop, 96→120px tablet, 72→80px mobile — crest now dominant and legible
- Nav link font: 0.9375rem→1rem (links + dropdown trigger) for visual balance with larger logo

### [2026-04-21] — Fix logo too small to read (index.html)
- Root cause: 72px max on a 400×400 detailed crest = unreadable at that scale
- Fix: desktop 72→120px, tablet 64→96px, mobile 52→72px — detail now visible at all breakpoints
- Two-row grid layout preserved; nav height auto-adjusts to larger logo

### [2026-04-21] — Fix nav clipping + logo rendering (index.html)
- Changed to `height:auto; min-height:80px` with two-row grid (logo row 1 spanning all cols, links row 2)
- Removed `image-rendering: crisp-edges` → `auto` for smooth bicubic downscaling

### [2026-04-21] — Step 7: Cross-page consistency pass — nav plan COMPLETE ✅
- Verified all 6 pages: identical nav CSS, markup, logo URL, and mobile overlay
- `web-pro-elite.html`: added 480px mobile breakpoint, fixed hamburger `display:flex`, responsive overlay padding + logo sizing
- `homepage-v2.html`: PharmoBoost label already fixed in earlier step
- No leftover cream backgrounds, teal nav accents, or old brand text remain in any nav section
- Logo CDN URL `uploaded-asset-1776767932323-0.png` confirmed correct across all 6 files

### [2026-04-21] — Step 5: Nav typography polish and micro-interactions across all 6 pages
- `letter-spacing: 0.04em` added to all `.nav-links a`, `.nav-links-right a`, `.nav-dropdown-trigger`, `.nav-cta`
- Gold underline-slide hover animation (::after pseudo, width 0→100%, ease 0.3s) on all nav links + dropdown trigger
- `.nav-cta` text colour → `var(--gildhart-green)` for better contrast on gold bg; added subtle gold box-shadow + translateY(-1px) hover lift
- `.nav-cta::after { display:none }` prevents underline animation on CTA button
- Dropdown trigger underline stops short of arrow: `width: calc(100% - 1em)`
- All 6 pages: index, homepage-v2, ai-domination-system, case-study-ealing, salesagent, web-pro-elite

### [2026-04-21] — Step 4: Centre logo as dominant nav element across all 6 pages
- Nav layout: `flex` → `grid-template-columns: 1fr auto 1fr` — three-column layout with logo centred
- Links split: `.nav-links` (left: Services dropdown + Pharmacies + Clinics) and `.nav-links-right` (right: Case Studies + Playbook + CTA)
- Logo: 80px → 100px desktop, 80px tablet, 64px mobile — gold drop-shadow + hover glow
- Nav height: 100px → 110px desktop, 96px tablet, 80px mobile
- Mobile: falls back to `display:flex` with logo left, hamburger right (both `.nav-links` and `.nav-links-right` hidden)
- All 6 pages: index, homepage-v2, ai-domination-system, case-study-ealing, salesagent, web-pro-elite

### [2026-04-21] — Step 3: Nav background + colour palette → forest green across all 6 pages
- `.nav` bg: cream → `rgba(30,61,47,0.97)` (forest green) on index, homepage-v2, ai-dom, case-study, salesagent, web-pro-elite
- `border-bottom`: black 7% → gold 18% (`rgba(201,164,74,0.18)`) — subtle luxury divider
- `.nav-links a`, `.nav-dropdown-trigger`: gray-600 → `#FAF5EE` (cream/off-white); hover → `var(--gildhart-gold)`
- `.nav-cta`: navy bg → `var(--gildhart-gold)` bg with dark text; hover → `#b8912f`
- `.nav-hamburger`: navy → `#FAF5EE` (cream stroke)
- `.nav-mobile-overlay`: cream bg → `rgba(30,61,47,0.99)` forest green; link colours → `#FAF5EE`, hover → gold
- `.mobile-nav-cta`: navy → gold bg with dark text (matches desktop CTA)
- Mobile section labels + sub-items: muted cream `rgba(250,245,238,0.45)`

### [2026-04-21] — Nav audit: mapped structure across all 6 pages for premium green redesign
- Audited nav markup (.nav, .nav-inner, .nav-brand, .nav-links, .nav-hamburger, .nav-mobile-overlay) on all 6 HTML files
- Key findings: homepage-v2 still uses "PharmoBoost" dropdown label (all others say "Services"); homepage-v2 has slightly different bg opacity
- Current nav bg: cream rgba(254,247,237,0.97) on 5 pages, rgba(245,242,236,0.97) on homepage-v2
- Logo: uploaded-asset-1776767932323-0.png at 80×80 across all pages
- Plan: steps 3–7 will change nav bg to #1E3D2F, text to white/cream, centre logo larger, fix homepage-v2 label

### [2026-04-21] — Fix broken CSS on 5 pages: duplicate `.nav-brand {` selector
- Root cause: during logo step 3, a duplicate `.nav-brand {` was introduced (unclosed first brace) on salesagent, web-pro-elite, ai-domination-system, case-study-ealing, homepage-v2
- This broke all CSS rules after the nav section, causing completely unstyled pages
- Fix: removed the extra `.nav-brand {` line on all 5 files; index.html was unaffected
- All pages now render correctly with full styling restored

### [2026-04-21] — Nav logo step 4: responsive sizing at tablet + mobile breakpoints
- Added `@media (max-width: 1024px)` — logo 64px, nav 88px, overlay top 88px (all 6 pages)
- Added `@media (max-width: 768px)` — logo 48px, nav 72px, overlay top 72px, tighter padding (all 6 pages)
- Logo no longer dominates mobile nav; hamburger button has comfortable breathing room
- Complete plan: steps 1–4 done across index, homepage-v2, ai-domination-system, case-study-ealing, salesagent, web-pro-elite

### [2026-04-21] — Nav logo step 3: replicate logo across all 5 site pages
- Added `.nav-brand img` CSS (max-width/max-height 80px, crisp-edges, no clipping) to: homepage-v2, ai-domination-system, case-study-ealing, salesagent, web-pro-elite
- Replaced plain text "Gildhart" nav-brand with `<img>` tag (same src, width/height/loading/decoding/fetchpriority as index.html)
- Bumped `.nav-inner` height from 72px→100px and `.nav-mobile-overlay` top from 72px→100px on all 5 pages
- Logo now renders consistently site-wide across all 6 HTML files

### [2026-04-21] — Nav logo step 2: img attributes + CSS max-width approach (index.html)
- Added HTML `width="80" height="80" loading="eager" decoding="async" fetchpriority="high"` to nav logo `<img>`
- CSS switched from fixed `width:80px;height:80px` to `max-width:80px;max-height:80px;width:auto;height:auto`
- `image-rendering: crisp-edges` + `-webkit-optimize-contrast` for sharper browser downscaling
- Prevents layout shift + ensures logo loads immediately as highest priority asset
- Source image still oversized — user may want to re-upload web-optimised 200–300px version for best clarity

### [2026-04-21] — Nav logo CSS fix step 1: sizing + rendering (index.html)
- `.nav-brand img`: 70px→80×80px explicit width/height, `image-rendering:auto`, `border-radius:0`, `overflow:visible`, `flex-shrink:0`
- `.nav-inner` height: 90px→100px for comfortable logo breathing room
- `.nav-mobile-overlay` top: 90px→100px to match new nav height
- Removed redundant "Gildhart" text previously (logo contains brand name)
- Footer + gh-divider still reference old broken `uploaded-asset-1776672268791-0.png` — next step to update

### [2026-04-21] — Full teal purge on index.html: pathway section + all decorative teal replaced
- SalesAgent Pro proof banner: `#14b8a6` → `var(--gildhart-green)` (inline style)
- Featured DFY card: proof banner, recommended label, check marks, border → forest green / gold
- AI mockup #1 rank bubble: `var(--teal)` → `var(--gildhart-green)`
- Revenue card accent strips + dividers: teal → gold gradient
- Revenue card hover glows, featured card shadows, ambient glow → gold or removed
- `featured-case-image::before` border: teal → forest green
- `featured-cta-card:hover` border: teal → forest green
- `scorecard-row.highlight` bg, `dd-item:hover`, `split-card:hover` border → forest green tints
- Animation keyframes (`shiftAiGlow`, `tpSlideUpFeatured`) → gold/green
- `shift-col-new` label bg, btn box-shadows: teal → gold/green equivalents

### [2026-04-21] — Sachin Mehta quote: highlighted text (300%, "patients actually booking appointments") → forest green
- `.featured-quote strong` color: `var(--teal)` → `var(--gildhart-green)` (#1E3D2F) in index.html

### [2026-04-21] — Gildhart colour system: teal → forest green + gold (all 5 pages)
- Replaced teal (#14b8a6) with --gildhart-green (#1E3D2F) on: CTA strips, card borders, stat accents, hero eyebrow underlines, method/step circles, proof tags, buttons
- Gold (#C9A44A) replaces teal as the standalone "pop" colour for eyebrow labels, stat numbers, underline accents
- Nav brand span: teal → gold (index + cross-page)
- Page <title> tags: "PharmoDigital" → "Gildhart" on ai-domination-system, salesagent, web-pro-elite, case-study-ealing
- Nav: "PharmoBoost" dropdown trigger → "Services" on 4 remaining pages; nav brand "PharmoDigital" → "Gildhart"
- Contact email: hello@pharmodigital.com → hello@gildhart.com on salesagent, web-pro-elite, case-study-ealing
- Teal retained only for functional interactive elements (AI mockup rank bubble, hover borders, timeline fill)

### [2026-04-21] — Gildhart Rebrand Step 3 + retry: index.html nav & brand text fixed
- Nav brand updated: `Pharmo<span>Digital</span>` → `Gildhart` (plain text, no span)
- Nav dropdown trigger + mobile label: "PharmoBoost" → "Services"
- Founder section: "PharmoDigital" → "Gildhart" in title and inline copy
- Contact email: `hello@pharmodigital.com` → `hello@gildhart.com`
- Footer branding was already correctly applied from prior step; no re-edit needed

### [2026-04-21] — Gildhart Rebrand Step 3: Footer branding across all 6 pages
- Footer background → `#1E3D2F` (Gildhart forest green) on all 6 files
- Gildhart brand token block added to `:root` in all 6 files: `--gildhart-green`, `--gildhart-gold`, `--gildhart-cream`, `--gildhart-black`
- Footer `border-top` and `border-bottom` dividers → gold `rgba(201,164,74,0.25/0.2)` replacing white opacity
- `.footer-brand-link` color → `--gildhart-gold` (#C9A44A) across all files
- `.footer-col a:hover` → `--gildhart-gold` (was `white`) across all files
- `.footer-brand-name` text → "Gildhart" in all 6 footers; copyright → "© 2026 Gildhart."
- Logo `<img>` placeholder deferred pending asset upload (dark-green-bg variant needed)
- Files edited: index.html, homepage-v2.html, ai-domination-system.html, case-study-ealing.html, salesagent.html, web-pro-elite.html

### [2026-04-20] — AI Domination System: THE SYSTEM section — replaced all emoji icons with SVG (ai-domination-system.html)
- Removed all 5 emoji icons (⚡🏗🧩🎨🚀) from .system-module cards, replaced with stroke SVG icons (22px, stroke-width 2)
- Removed emojis from tier cards (📚⚡🤝) and guarantee badge (🛡) — same SVG treatment
- Icon colors: engine teal, pillar indigo, interactive amber, visuals sage, indexed emerald — all from existing palette
- SVG icons match site&#39;s existing stroke icon language (same style used in split-section cards on homepage)

### [2026-04-20] — AI Domination System: THE SYSTEM section — full card redesign (ai-domination-system.html)
- Switched from stacked single-column list to 2-column grid (2+2+1 centred) for shorter scroll + visual variety
- Each card: distinct icon (.system-module-icon), bold one-line hook (.system-module-hook), reduced-weight body copy
- Pulled proof stat callout (.system-module-proof) per card — teal left-border, large stat number + context label
- Stats: "£0/mo", "6 wks", "6m 40s", "£0", "48 hrs" — scanners see the knockout numbers without reading paragraphs
- Responsive: ≤900px collapses to 1-col; ≤768px tighter padding/fonts; existing JS cascade animation still targets .system-module

### [2026-04-20] — AI Domination System: THE SYSTEM section step 4 — emoji/symbol audit (ai-domination-system.html)
- Confirmed #what-you-get section is fully clean: no emojis, no ✓/✗ icons, no decorative symbols
- Removed orphaned CSS: `.system-module-subheadline`, `.system-module-checks`, `.system-module-check-item`, `.check-icon`
- Numbered circles (01–05) remain as the sole visual element per card

### [2026-04-20] — AI Domination System: THE SYSTEM section step 3 — card body CSS (ai-domination-system.html)
- Added `.system-module-body` class: color #4b5563, font-size 0.9375rem, line-height 1.7, margin 0
- Inserted before legacy `.system-module-subheadline` rule (kept for now, cleanup in step 4)
- Completes typography for new paragraph-style card body copy

### [2026-04-20] — AI Domination System: THE SYSTEM section step 2 — five cards rewritten (ai-domination-system.html)
- All 5 `.system-module` cards: removed `.system-module-subheadline` + `.system-module-checks` bullet lists
- Replaced with single `.system-module-body` paragraph per card (new class, CSS in step 3)
- Card titles: "Your AI Content Engine", "The Pillar Domination Method", "Interactive Content That AI Trusts", "Professional Visuals Without The Bill", "Indexed In Days, Not Months"
- Numbered circles (`.system-module-num`) kept unchanged as sole visual element

### [2026-04-20] — AI Domination System: THE SYSTEM section step 1 — headline + subhead replaced (ai-domination-system.html)
- Replaced headline with "What Ealing, Superior, and Puri Actually Used. Now Yours."
- Replaced subhead with five-components copy; max-width 700px centred

### [2026-04-20] — Homepage: redesigned final closing section v2 — hierarchy overhaul (index.html)
- Pulled 4.4× Semrush stat out as a large isolated callout (teal border-left, number + label treatment)
- Left-aligned body copy — 2 paragraphs, more readable, less wall-of-text
- "What you do in the next 90 days…" isolated as a large italic gut-punch line between body and CTAs
- Italic headline stays centred at top; button styles cleaned up (removed duplicate btn-outline-white class)
- Staggered scroll animation chain: headline → stat → body → final line → CTAs (0.25s apart)

### [2026-04-20] — Homepage: redesigned final closing section v1 before footer (index.html)
### [2026-04-20] — Homepage: redesigned final closing section before footer (index.html)
- Replaced old "Across 50+ practices" + "Your practice. Your path." + 3-button CTA with centred closing copy
- New `.revenue-close-section`: max-width 800px, centred, italic headline + 3 persuasive paragraphs + 2 CTAs
- Primary: "See If You're On The AI Shortlist →" (teal solid), Secondary: "See What We Build →" (white outline)
- Removed "Choose Your Practice Type" button, "Across 50+" sub, "Your practice. Your path." text entirely
- Updated scroll animations to match new DOM: headline→body→buttons stagger with same rev-visible trigger

### [2026-04-20] — AI Domination System: Shift section — pulsating arrow connectors (ai-domination-system.html)
- Arrow color: rgba(255,255,255,0.25) → amber (#f59e0b) with `arrowPulse` keyframe animation
- Pulse: color fades 0.5→1 opacity, amber text-shadow glow, slight 3px translateX nudge — 2s infinite loop
- Staggered delays: each row offset by 0.3s so arrows cascade down sequentially
- Font-size bumped 1.25rem → 1.5rem for better visibility
- Mobile: separate `arrowPulseMobile` keyframe accounts for 90deg rotation; color/glow matched

### [2026-04-20] — AI Domination System: Shift section premium animations (ai-domination-system.html)
- Eyebrow label fades in on scroll, headline reveals word-by-word (55ms stagger per word)
- Intro paragraph slides up with 0.3s delay after headline
- 5 paired stat/consequence rows cascade in with 160ms stagger, each row fades up from 28px
- Stat numbers count up with ease-out cubic animation (1s duration) then trigger amber glow pulse keyframe
- Consequence (lose) side slides in from right with 350ms delay — creates "stat appears → consequence follows" narrative
- Arrow connector fades in between the two halves; mobile overrides use translateY instead of translateX
- All animations use IntersectionObserver, fire once, threshold-based for natural scroll feel

### [2026-04-20] — AI Domination System: hero layout fix — match homepage proportions (ai-domination-system.html)
- Root cause: max-width 1200px + 1fr 1fr grid + 5rem gap + object-fit:contain = squished wide image
- Fix: max-width 1400px, grid 1fr 1.15fr, gap 3rem, object-fit:cover — matches homepage hero approach
- Homepage uses 1400px / 1fr 1.1fr / 3rem gap — now both heroes share same proportional logic

### [2026-04-20] — AI Domination System: hero image replaced (ai-domination-system.html)
- Swapped hero image to new pharmacy logos + phone booking mockup (uploaded-asset-1776669430182-0.jpeg)
- Removed 1deg rotation (transform: none) so wide image renders straight without distortion
- Added object-fit: contain + display: block for clean full-width rendering
- Old image: uploaded-asset-1772985250408-0.jpeg → deleted from markup

### [2026-04-20] — AI Domination System: Shift intro paragraph readability on desktop (ai-domination-system.html)
- `.problem-shift-intro`: max-width narrowed 780px → 640px to shorten line length for easier reading
- Font-size bumped 1.0625rem → 1.1875rem; color opacity raised 0.82 → 0.88; line-height 1.75 → 1.8
- Added subtle letter-spacing (0.005em) for improved tracking on dark bg
- Copy unchanged — purely a rendering/readability improvement

### [2026-04-20] — AI Domination System: Shift section step 5 — responsive collapse + mobile treatment (ai-domination-system.html)
- ≤768px: `.ps-pair-row` stacks vertical — stat on top, arrow separator, full-width red warning zone below
- Disabled hover lift on mobile (no transform); reduced border-left to 3px; border-radius 14px
- Stat text/number sizes scale down: clamp(2rem,7vw,2.75rem), stat-text 0.875rem, lose-text 0.9375rem
- Added ≤420px breakpoint for small phones: tighter padding (1rem), smaller icons (24px), compact text
- Completes all 5 steps of the paired stat/consequence row redesign plan

### [2026-04-20] — AI Domination System: Shift section step 4 — typography hierarchy + arrow connector (ai-domination-system.html)
- `.ps-pair-stat-num`: font-size bumped to clamp(2.5rem, 4vw, 3.25rem), weight 900, subtle amber text-shadow
- `.ps-pair-vs`: changed from 1px divider with "vs" to 48px wide arrow (→) connector at 1.25rem — visual flow between win/lose
- `.ps-pair-lose-icon`: size raised to 32px circle, red opacity bumped to 0.9/0.14 for stronger warning presence
- `.ps-pair-lose-text`: opacity raised to 0.82, line-height to 1.55 for improved legibility
- Mobile: arrow rotates 90° on stack; stat numbers scale down elegantly

### [2026-04-20] — AI Domination System: Shift section step 3 — card/panel treatment for pair rows (ai-domination-system.html)
- `.ps-pair-row`: border-left 4px solid #f59e0b (amber accent), border-radius 16px, box-shadow depth, hover lift
- `.ps-pair-win`: background rgba(245,158,11,0.04) — subtle warm amber tint on stat side
- `.ps-pair-lose`: background rgba(239,68,68,0.06) — red warning zone on consequence side
- Padding bumped to 2rem 2.5rem for more breathing room; gap tightened to 1.25rem for tighter rhythm
- Mobile: tinted backgrounds preserved at lower opacity for readability

### [2026-04-20] — AI Domination System: Shift section step 2 — warm amber stats + legible consequences (ai-domination-system.html)
- `.ps-pair-stat-num` color changed from var(--teal) to #f59e0b (warm amber/gold) — breaks teal monotony, pops on navy
- `.ps-pair-lose-icon` color raised from rgba(220,80,80,0.6) to rgba(239,68,68,0.85) + bg to 0.12 — clearer red warning
- `.ps-pair-lose-text` opacity raised from 0.6 to 0.78 — actually legible now
- Creates amber=winning / red=losing colour story within the section

### [2026-04-20] — AI Domination System: Shift section — paired stat/consequence rows step 1 (ai-domination-system.html)
- Replaced two-column grid (`.problem-shift-columns`) with `.ps-pair-rows` — 5 paired flex rows
- Each row: `.ps-pair-win` (stat left) + `.ps-pair-vs` divider + `.ps-pair-lose` (consequence right)
- Consequence icons use red-tinted circle (rgba(220,80,80,0.6)) for warning emphasis
- "vs" label on thin divider between halves; rows have subtle card bg (rgba white 0.04)
- Mobile: rows collapse to vertical stack; headline/intro/teal banner untouched

### [2026-04-20] — AI Domination System: merged Problem+Shift into unified dark navy section (ai-domination-system.html)
- Removed split 40/60 Problem-left / Shift-right layout entirely
- New single `.problem-shift-section` with dark navy bg, white text throughout
- Headline, single intro paragraph, teal banner below completely untouched

### [2026-04-19] — AI Domination System: hero subtext, stats, remove badge, Shift paragraph (ai-domination-system.html)
- Hero subtitle replaced with Rahul/Raman/Sachin named-result copy + "No ad spend" kicker
- Stats updated: Ealing revenue growth / Superior ChatGPT sales / Puri Mounjaro £100k
- £497 floating badge removed entirely from hero image column
- "The Shift" section paragraph replaced with 4-paragraph Boots-to-AI narrative inc. Semrush 4.4× stat
- Old Game / New Game cards and teal strip left completely untouched

### [2026-04-17] — WPE hero: remove subtext bold, larger photo, clean label (web-pro-elite.html)
- Removed all <strong> and <em> tags from .wpe-hero-subtitle — plain weight 400 body text throughout
- Fixed malformed `<strong>Rahul</>` closing tag
- Photo size: 68px → 80px circle, object-position changed to center 10% to better frame face
- Label text confirmed as "FROM A WEBPRO ELITE CLIENT" — rendering issue was screenshot quality only

### [2026-04-17] — WPE hero: Rahul headshot in card + structured subtext (web-pro-elite.html)
- Embedded hosted photo (animaapp.com URL) as circular 68px headshot with name/title in photo-row above label
- Removed `.wpe-hero-ts-attr` line (attribution now lives in photo-row)
- Subtext broken into 3 named-result lines (Rahul / Raman / Sachin) + bold closing kicker — no longer a dense block
- Added `.wpe-hero-ts-photo-row`, `.wpe-hero-ts-photo`, `.wpe-hero-ts-photo-meta` CSS rules

### [2026-04-17] — WPE hero card amend: sans-serif quote, bigger label, taller card (web-pro-elite.html)
- .wpe-hero-ts-quote: switched from Cormorant Garamond italic 700 → Outfit/Inter sans-serif 400 normal, smaller clamp for readability
- .wpe-hero-ts-label: font-size 0.6rem → 0.75rem (clearly legible), letter-spacing tightened slightly to 0.18em
- .wpe-hero-testimonial-single: padding 2.5rem → 3.25rem 2.75rem, min-height: 360px, flex-column justify-center for vertical fill

### [2026-04-17] — WPE hero plan step 3: single large testimonial card (web-pro-elite.html)
- Removed .wpe-hero-testimonials grid and both small cards from right column markup
- Added .wpe-hero-testimonial-single: white bg, 16px radius, 2.5rem padding, homepage-matching shadow
- Label: .wpe-hero-ts-label — Space Mono, teal, 0.22em tracked small-caps
- Quote: .wpe-hero-ts-quote — Cormorant Garamond italic, navy, clamp(1.3rem→1.65rem)
- Attribution: .wpe-hero-ts-attr — grey, 0.9375rem — no stats bar

### [2026-04-17] — WPE hero plan step 2: headline scale + subhead copy (web-pro-elite.html)
- .wpe-hero-title font-size raised to clamp(2.25rem, 3.8vw, 3.5rem) — matches homepage headline scale
- .wpe-ht-line1 / .wpe-ht-line3 letter-spacing tightened to -0.03em for commanding feel
- .wpe-ht-line2 kept at 1.08em relative size (Cormorant matches Inter 800 visual weight at same scale)
- Subhead paragraph replaced with Rahul/Raman/Sachin proof copy (grey body font, no change to style rules)
- Both CTA buttons left completely untouched

### [2026-04-17] — WPE hero redesign plan step 1: full-width container + 60/40 grid (web-pro-elite.html)
- Added `width: 100%` to .wpe-hero to ensure full viewport use
- Raised .wpe-hero-inner max-width: 1400px → 1600px to remove box-in constraint
- Grid ratio: 62fr/38fr → 60fr/40fr (cleaner ratio, left col still dominant)
- Horizontal padding stays at 1.5rem each side (already set from prior step)

### [2026-04-17] — WPE hero plan step 3: expand left text column grid ratio (web-pro-elite.html)
- Changed .wpe-hero-inner grid-template-columns from 1fr 1fr → 62fr 38fr
- Left column gains ~12% more width, giving headline more horizontal space
- No other layout, typography, or card changes

### [2026-04-17] — WPE hero plan step 2: widen hero container, reduce outer padding (web-pro-elite.html)
- .wpe-hero-inner max-width was already 1400px (set in a prior session) — no change needed there
- Reduced .wpe-hero horizontal padding: 4rem 2rem 5rem → 4rem 1.5rem 5rem (0.5rem less each side)
- No grid, typography, or card changes

### [2026-04-17] — WPE hero plan step 1: remove large top-right testimonial card (web-pro-elite.html)
- Deleted .wpe-hero-statement block (big Rahul Puri quote card above the two smaller cards)
- .wpe-hero-testimonials grid and both smaller cards left completely untouched
- No CSS, typography, or other structural changes

### [2026-04-17] — WPE hero: adjust headline font sizes (web-pro-elite.html)
- Lines 1 & 3 base: clamp reduced 10% → clamp(1.98rem, 3.47vw, 2.7rem) from clamp(2.2rem, 3.85vw, 3rem)
- Line 2 (.wpe-ht-line2): font-size bumped 1em → 1.12em to match visual weight of Inter 800 on L1/L3
- No other changes; layout, colours, spacing all untouched

### [2026-04-17] — WPE hero: remove excess top space (web-pro-elite.html)
- Root cause: `min-height: calc(100vh - 72px)` with `align-items: center` was vertically centring content, pushing headline down
- Fix: set `min-height: 0` and `padding: 4rem 2rem 5rem` — section now sizes to content only
- No layout, typography, or other structural changes

### [2026-04-17] — WPE hero: corrected mixed-type headline treatment (web-pro-elite.html)
- .wpe-hero-title base: Inter/Outfit 800, clamp(2.2rem, 3.85vw, 3rem) — ~20% reduction from previous clamp(2.75rem, 4.8vw, 3.75rem)
- .wpe-ht-line1 + .wpe-ht-line3: Inter/Outfit sans-serif 800, normal, navy — retain original typeface
- .wpe-ht-line2: Cormorant Garamond italic 700, teal, same 1em size as lines 1 & 3 (no size hierarchy)
- Cormorant Garamond restricted to .wpe-ht-line2 only — no other page elements affected
- Removed previous Cormorant/Playfair serif from lines 1 & 3; those lines now correctly stay in sans-serif

### [2026-04-17] — WPE hero Step 3: Scoped CSS for mixed-type treatment (web-pro-elite.html)
- Replaced .wpe-hero-title Inter/800 rule with Cormorant Garamond/Playfair Display/Georgia/serif at 700
- .wpe-ht-line1 + .wpe-ht-line3: display:block, font-weight:700, font-style:normal, color:navy, 1em
- .wpe-ht-line2: display:block, font-weight:700, font-style:italic, color:var(--teal), font-size:1.18em for hierarchy
- No layout/structural changes; legacy .wpe-hero-title-accent and .wpe-hero-title-sub rules preserved

### [2026-04-17] — WPE hero Step 2: Restructure h1 into three styled spans (web-pro-elite.html)
- Replaced existing h1 text (plain text + br tags) with three block spans: .wpe-ht-line1, .wpe-ht-line2, .wpe-ht-line3
- Removed old .wpe-hero-title-accent span; each line is now independently targetable via class
- Step 3 next: add scoped CSS — Cormorant Garamond font, navy/italic-teal/navy treatment, size hierarchy

### [2026-04-17] — WPE hero Step 1: Load Cormorant Garamond + Playfair Display (web-pro-elite.html)
- Added Cormorant Garamond 700 + 700 Italic and Playfair Display 700 + 700 Italic to Google Fonts link
- Both families appended to existing Inter/Outfit/Space Mono bundle — single request, no extra preconnect needed

### [2026-04-17] — WPE hero: replace 3 stats cards with 2 testimonial cards (web-pro-elite.html)
- Removed .wpe-hero-metrics grid (6 wks / £0 / 50+) entirely
- Added .wpe-hero-testimonials: 2-col grid matching existing statement card style (white bg, rounded, same shadow/padding)
- Card 1: Rahul Puri quote + "On track for six figures this year." in teal bold
- Card 2: Raman Superior Pharmacy quote + "On track for £500k this year." in teal bold
- Revenue line separated by teal top-border for visual distinction; stacks to 1-col below 640px

### [2026-04-16] — WPE hero headline + dedup (web-pro-elite.html)
- Removed "WEBPRO ELITE" eyebrow label from hero entirely
- Hero h1 restructured: 3 lines — navy / teal / navy; no line runs into the next
- Deleted duplicate Package section + duplicate Pricing/CTA section (both were rendering twice)
- Page now flows: Portfolio → Package → Pricing → Footer (no repetition)

### [2026-04-16] — WPE Package section: premium dark redesign (web-pro-elite.html)
- Swapped cream bg + white cards → dark immersive layout (matches homepage Revenue Results section style)
- Cards now glassmorphic: rgba bg, teal left accent strips, hover lift+glow, backdrop-blur
- Removed emoji icons, replaced with `01`/`02` Space Mono numbering (like revenue card labels)
- Timeline strip now dark variant with teal week numbers and light text
- Both duplicate package sections updated (file still has dupes)
- Section header text now white/teal to match dark bg

### [2026-04-16] — WPE Hero: eyebrow restyle, Kern subtext, waitlist CTA (web-pro-elite.html)
- Eyebrow: removed border/box badge → plain grey uppercase text (no longer looks cheap)
- Subtext rewritten Kern/Brown style: "Three pharmacies. Three cities. All outranking national chains..."
- All CTAs → "Join The Waitlist" (hero, nav, mobile nav, both CTA form sections)
- Form success state → "You're on the list" with 2–4 week messaging
- Fixed duplicate CTA section still showing old "Book A Strategy Call" text
- NOTE: file still has duplicate Portfolio/Package/CTA sections that need dedup

### [2026-04-16] — WPE Hero: cream palette overhaul (web-pro-elite.html)
- Swapped dark immersive hero bg → homepage's warm cream gradient (cream→teal linear-gradient)
- All hero text now navy/gray on cream instead of white-on-dark; kills the "AI template" look
- Removed: pill badge, proof-line paragraph, trust bar below hero, subtitle sub-line — stripped text density by ~60%
- Right column: Rahul Puri testimonial now in white card with border/shadow; 3 metric tiles in white cards
- CTAs restyle: teal filled + navy outline (matching homepage button pattern)
- Stats line below CTAs: compact Space Mono uppercase like homepage hero

### [2026-04-16] — WebPro Elite Steps 3+4 complete (web-pro-elite.html)
- Portfolio section: 3 client cards (Chiselhurst, Easy Clinic, Puri) with live iframe previews in browser chrome mockup
- Package section: dual-col (WebPro Elite Site + Pillar Domination Framework™) + 4-step delivery timeline strip
- Pricing + CTA section: dark navy, starts-from £3,500 block, 3 trust guarantees, contact form with success state
- Form submit: handleWpeFormSubmit() shows success card, hides form — no page reload
- homepage-v2.html has no PharmoBoost dropdown; no wiring needed there

### [2026-04-16] — WebPro Elite Step 2: page structure + hero section (web-pro-elite.html)
- Created web-pro-elite.html from scratch — dark immersive hero, sticky nav, PharmoBoost dropdown wired
- Hero: teal pill badge, animated title, three client cards (Chiselhurst, Easy Clinic, Puri), 4-stat bar, trust bar
- Intro/positioning section: proof cards (Ealing 300%, Superior 50%, Puri national), scroll-reveal animations
- Wired `web-pro-elite.html` link into dropdown in index.html and salesagent.html (desktop + mobile)
- Step 3 next: three client portfolio showcase cards

### [2026-04-12] — Replace third card in "Which One Is You?" section (index.html)
- Removed "By Practice Type / See Proof From Your World" card entirely
- New card: SalesAgent Pro — teal banner strip, Sachin/Southdowns body copy, 4 teal tick bullets, no price
- CTA button: teal full-width "See What It Does →" linking to salesagent.html
- First two cards (DIY Playbook + DFY) left completely untouched

### [2026-04-12] — Sachin avatar: 96px + tighter face crop (salesagent.html)
- Bumped avatar from 64px → 96px (three-quarter body shot needs more room to show face)
- object-position tightened from `50% 12%` → `50% 5%` to pull face fully into the circle
- Hosted image: uploaded-asset-1776010896483-1.png

### [2026-04-12] — Improve flywheel section text readability (salesagent.html)
- `.sa-flywheel-card-text` bumped from rgba(255,255,255,0.55) → rgba(255,255,255,0.85)
- `.sa-flywheel-desc` subheading bumped from 0.55 → 0.80 opacity for legibility on dark bg

### [2026-04-12] — Increase Live Right Now footnote text size (salesagent.html)
- `.sa-live-clients-footnote` font-size bumped from 1rem → 1.1875rem, line-height 1.7 → 1.75

### [2026-04-12] — Replace two-column bullet layout in three feature cards (salesagent.html)
- Removed bold label + em-dash two-column split from all three .sa-why-block cards
- Card 1: 3 clean sentences — clinical depth, patients stay on site, engaged patients book first
- Card 2: 3 clean sentences — intent data, real patient language ranks, practice becomes authority
- Card 3: 3 clean sentences — clinical authority, agent learns patients, competitors can't catch up
- Existing teal tick CSS (::before) renders correctly — no bold/strong tags in new copy

### [2026-04-12] — Update Live Right Now section copy (salesagent.html)
- Headline: "The Practices That Saw Where Healthcare Was Going."
- Subhead: expanded to "Six independent practices already operating with AI at the core of their patient acquisition. Not piloting it. Not planning it. Running it."
- Overline unchanged: "Live Right Now"

### [2026-04-12] — Add Track Record guarantee section (salesagent.html)
- New `.sa-track-record` section inserted between Why This Exists and SalesAgent Pro (dark) sections
- Background #f7f0e6, centred layout, max-width 820px, no icons/borders/cards — pure typography
- Overline: teal spaced caps; headline: large bold navy; body: dark grey generous line-height
- Closing line "We&#39;ve never had to." has 4rem top margin to land as standalone statement
- Removed old `.sa-closing-confidence` guarantee block from inside the pricing section entirely

### [2026-04-12] — Fix hero overlapping nav (salesagent.html)
- Removed `margin-top: -45px` from `.sa-hero` — was pulling hero content behind sticky nav
- No other layout changes

### [2026-04-12] — Hero subhead + CTA rewrite (salesagent.html)
- Replaced subtitle paragraph with 4-element block: bold loss line + 2 story paragraphs (Sachin/Nemesh)
- Bold line: "That patient was probably worth £480. Possibly £3,000. Definitely gone." — dark navy, larger text
- Story paragraphs: regular body weight, #4b5563, with clear spacing between each
- CTA changed: "Check If Your Practice Is Eligible" → "Deploy SalesAgent Pro This April"
- "Check If Your Practice Is Eligible" secondary link removed entirely

### [2026-04-12] — Replaced closing testimonial quotes with verbatim client text (salesagent.html)
- Card 1: Sachin Mehta, Ealing Travel Clinic — "To be honest I wasn't expecting much…"
- Card 2: Southdowns Pharmacy Group — "We didn't realise how many enquiries we were losing…"
- Card 3: Superior Pharmacy — "Half our weight loss bookings come through it now…"
- Pull quote in right column updated to match Southdowns' new verbatim wording
- Names/roles updated: Card 1 now shows "Sachin Mehta" as name, "Ealing Travel Clinic" as role

### [2026-04-12] — Step 4: Scroll-reveal animation + responsive behaviour (salesagent.html)
- Testimonial card delays changed from d4/d5/d6 → d1/d2/d3 so they reveal relative to their own viewport entry
- Mobile ≤1024px: testimonials become horizontal snap-scrollable trust strip (flex-row, scroll-snap, hidden scrollbar)
- Mobile ≤768px: card width 88%, reduced padding/font for compact fit
- Added transition on opacity for smoother card entrance
- Plan "Add client testimonials/social proof to left column" — all 4 steps complete

### [2026-04-12] — Reframed closing testimonial quotes for objection coverage (salesagent.html)
- Card 1 (Ealing): speed — "live Thursday, bookings by Friday morning" → will it work?
- Card 2 (Southdowns): ROI — "£200k revenue from chatbot conversations, ROI isn't close" → worth money?
- Card 3 (Superior): ease — "I haven't touched it in months, half bookings overnight" → hassle?
- Quotes now personal first-person voice, 2 sentences max, varied objection types
- Step 3 of 4 complete; next: step 4 (scroll-reveal animation + responsive behaviour)

### [2026-04-12] — Built 3 testimonial card components in closing left column (salesagent.html)
- New CSS: `.sa-closing-testimonials`, `.sa-closing-testimonial-card`, metric pill badge
- Teal left-border accent, #f0ede8 card bg, hover lift; visually lighter than right-col pricing
- Scroll-reveal with staggered delays (d4/d5/d6) — step 2 of 4 in testimonials plan

### [2026-04-12] — Closing section audit: mapped left column for testimonial insertion (salesagent.html)
- Left column (.sa-closing-offer): stack-label → 6-item value stack → eligibility bar → EMPTY SPACE
- Right column (.sa-closing-checkout-lane): bridge → proof row → pricing → guarantee → form → CTA
- Grid: `1fr 480px`, right col sticky at top:100px, collapses at ≤1024px
- Insertion point identified: after `.sa-closing-eligibility-bar`, inside `.sa-closing-offer`
- Next step: design and build 2–3 short testimonial card components for that slot

### [2026-04-12] — Closing section: restored two-column integrated layout (salesagent.html)
- Reverted from single-column flex to `grid-template-columns: 1fr 480px` at max-width 1200px
- Left column: value stack + eligibility card; Right column: pricing/checkout lane (sticky at top:100px)
- Mobile ≤1024px: collapses to single column, sticky removed
- Eliminates the empty right-hand space issue from previous single-col attempts

### [2026-04-12] — Closing/pricing section restructured per exact brief (salesagent.html)
- Reordered right column: proof row → pricing cards → punchline → guarantee → form → pull quote → bold close → CTA
- Added price-lock line on upfront card: "Price locked forever… renew at £995. Always."
- Bold closing line added: "£995. One year. One Mounjaro patient covers it entirely…"
- Eligibility criterion updated: "A website" → "A website that gets at least some traffic"
- Guarantee moved from left column to right column between punchline and form
- Deploy button changed navy → teal; "Joining 50+ practices…" added as final footnote

### [2026-04-12] — FAQ accordion section added above pricing (salesagent.html)
- New `.sa-faq` section: cream `#f7f0e6` background, max-width 820px centred, consistent page aesthetic
- 10 FAQ items as accordion — collapsed by default, teal chevron rotates on open, Q3 open on page load
- CSS: `.sa-faq-item`, `.sa-faq-question`, `.sa-faq-chevron`, `.sa-faq-answer` with `max-height` animation
- JS: click handler toggles `.open` class, manages `max-height` for smooth expand/collapse, sets `aria-expanded`
- Copy verbatim per brief — no words altered; mobile responsive with adjusted padding/font sizes

### [2026-04-12] — Numbers/Proof section: cream gradient colour retheme (salesagent.html)
- Background changed from dark navy gradient to warm cream gradient (`#faf7f2 → #f5f0e8 → #ede8df`)
- Cards: dark glass → white bg, dark navy text, teal accents; box-shadow tuned for light bg
- Label colour: dim white → teal; numbers/descriptors: off-white → navy; body text: dim white → gray-600
- Headline switched from `.sa-headline-white` → `.sa-headline-dark`; eyebrow from teal-on-dark → cream variant
- Card hover: reduced shadow intensity for light context; border-color shifts to teal on hover
- Added `border-top` on section for edge separation from preceding dark flywheel section

### [2026-04-12] — Content Flywheel: full design overhaul — dark standalone section (salesagent.html)
- Extracted flywheel from `.sa-chatbot` into its own dark navy `<section class="sa-flywheel-section">`
- Replaced 4-column inline grid with 2×2 card layout (`sa-flywheel-grid`) + centre animated loop ring
- Each card: dark glass background, teal top-line accent, faded step number, icon, title + one-liner
- Centre: pulsing ring with rotating ↻ icon + connecting vertical lines to cards
- Closing line + loop pill moved into the new section; old `.sa-chatbot-closing` removed
- Full mobile responsive: stacks to 1-col, loop ring above cards at ≤900px

### [2026-04-12] — Content Flywheel copy rewrite: Hormozi/Kern sales style (salesagent.html)
- Headline: "Patient Questions → Content That Ranks" → "Your Patients Write Your Marketing For You"
- All 4 step titles rewritten: benefit-first, active voice ("Patients Tell You What They Want", "We Find the Gold", "Content That Actually Converts", "You Show Up Everywhere")
- Step descriptions cut to 1-2 punchy sentences each, roughly equal length across all 4
- Intro paragraph simplified: flywheel concept explained in 3 plain sentences
- Closing line sharpened: "Your competitors are guessing… Your patients are *telling* you."

### [2026-04-12] — Problem section: added image alongside story text (salesagent.html)
- New `.sa-problem-story-grid` 2-col layout wrapping `.sa-story` + new image column
- Reuses hero image (booking confirmation phone) with dark section styling: deeper shadow, teal glow behind
- Image has scroll-reveal animation (fade up + scale) matching existing reveal system
- Mobile: stacks to 1-col with image on top (order: -1), max-width 360px centred
- No changes to story copy, stats, or any other section

### [2026-04-12] — Eligibility card: copy split + design overhaul (salesagent.html)
- First sentence kept italic via `<em>`, second/third sentences now regular-weight dark navy via `.sa-closing-eligibility-intro-body`
- "exactly these two criteria" → "just these two things"
- Card background changed from white to `#f0ede8` (subtle off-white) for separation from cream page
- Shadow boosted: `0 8px 36px rgba(0,0,0,0.1), 0 2px 10px rgba(0,0,0,0.06)` — clear lift off page
- Tick icons 30% larger (22px→28px), criteria text larger + bold (1rem/500→1.1875rem/700)
- Increased spacing: intro margin-bottom 0.25→1.5rem, overline margin-bottom 0.25→0.75rem, card padding bumped

### [2026-04-12] — Closing section: eligibility, bridge line, social proof row, pull quote (salesagent.html)
- Eligibility intro expanded: "Over 50 practices across the UK, US, and beyond…" context added
- Bridge line inserted between eligibility card and pricing: italic, centred, dark navy maths line
- Three-column social proof stat row (Southdowns £200k / Medihub Live / Raylane UK Network) below pricing cards
- Pull quote block above CTA button: cream background, Southdowns attribution, subtle separation
- New CSS: `.sa-closing-bridge`, `.sa-closing-proof-row/col/client/stat/label`, `.sa-closing-pull-quote`
- Mobile: proof row stacks to 1-col at 768px

### [2026-04-11] — Closing section: copy, pricing card, eligibility & guarantee overhaul (salesagent.html)
- Eligibility: added Frank Kern conversational intro line ("Honestly? If you're reading this…") above criteria
- Guarantee: 30-day patient enquiry commitment added; stress-test language retained
- 24/7 bullet replaced with Ealing Travel Clinic story (Sachin / HPV appointments / diary full)
- Authority bullet body: updated to name Google, ChatGPT, Claude, Bing, Gemini explicitly
- Pricing cards: 3-col grid (card / "or" / card), upfront card taller + elevated shadow + badge overlaps top
- Two distinct saving badges on upfront: teal (Save £505) + amber/gold (£1,500 setup waived — April only)
- Bold "Total saving this April: £2,005" line below badges; monthly card updated to "Setup fee waived this April"

### [2026-04-11] — Closing section: guarantee, pricing card, urgency banner fixes (salesagent.html)
- Guarantee replaced: "First booking within hours, or we rebuild it" → "We build it. We test it. We stand behind it." + performance rebuild guarantee
- Pricing card restyled for cream bg: white card, navy text, cream inputs, proper contrast throughout
- Form labels now dark navy (was white-on-white), inputs have visible borders on cream background
- Urgency banner: removed navy box + ⚡ emoji → clean inline typography, teal accent on key phrase, subtle rule below
- CTA button changed from teal → navy to match premium aesthetic; "Most Popular" badge now navy bg / white text

### [2026-04-11] — Hormozi-style closing section complete redesign (salesagent.html)
- Wall of text replaced: centred headline + single anchor line, then Hormozi value stack (6 scannable items with bold title + one-liner each)
- Added urgency banner (⚡ teal border) for April deadline
- Form labels contrast boosted from rgba(0.5)/0.75rem → rgba(0.75)/0.8125rem
- Right column now wrapped in subtle bordered card container (`.sa-closing-pricing`)
- Added risk reversal block with shield icon: "First booking within hours, or we rebuild it"
- Eligibility compressed into inline bar; three buried feature columns removed

### [2026-04-11] — Replaced eligibility + final CTA with merged closing section (salesagent.html)
- Original deletion of `.sa-eligibility` + `.sa-final` — first version of closing section

### [2026-04-11] — Fixed Why This Exists bullet wrapping: strong now inline, bold phrase flows into supporting text on one line (salesagent.html)
- Root cause: `display: block` on `strong` and `span` inside `li` was splitting each bullet onto multiple stacked lines
- Fix: removed `display: block` from strong, removed span entirely — each li is now plain inline text: **Bold phrase —** supporting line
- Rewrote all 9 bullet points to use em-dash inline pattern for clean single-line readability

### [2026-04-11] — "Why This Exists" cards: replaced paragraph body text with scannable bullet lists (salesagent.html)
- Each card now has 3 bullet micro-points: bold key phrase + short supporting line
- Added `.sa-why-block-bullets` CSS with teal tick icon via SVG data URI
- Lead paragraph tightened to 2 punchy lines; added destination pill badge (NHS.uk · Fit for Travel · patient.info)
- No structural or layout changes — cards still 3-col grid with white background and teal accent bar

### [2026-04-11] — Added "Why This Exists" cream section between carousel and stats (salesagent.html)
### [2026-04-11] — Added "Why This Exists" cream section between carousel and stats (salesagent.html)
- New `.sa-why` section inserted after `sa-live-clients`, before `sa-problem`
- Overline in teal spaced caps, large `Inter` headline (max 2 lines desktop), centred lead paragraph
- Three white cards (`.sa-why-block`) in 3-col grid with teal accent bar, icon, bold title, body copy
- Cards: "Answers Every Question", "Every Conversation Becomes Intelligence", "You Become Impossible to Displace"
- Hover lift + teal border glow; stacks to 1-col on mobile; scroll-reveal animated

### [2026-04-11] — Stat cards + bottom row overhaul in ChatGPT section (salesagent.html)
- Card 1: removed `.sa-stat-ring` circular graphic — stat now renders directly; body text replaced with full network data-point copy
- Card 2: attribution line updated to "Conversion rate — Southdowns Pharmacy Group"
- Card 3: replaced "Set & Forget" / "Install once" / "Running now" with "Every Conversation" headline + intent data body copy
- Bottom row: single wide rectangle → 3 individual cards matching top row (border, shadow, hover, border-radius); `.sa-revenue-bar-num` now white (#fff); new `.sa-revenue-bar-attribution` element; removed "Real client results" line; mobile stacks with gap
- All 6 cards: consistent border `rgba(255,255,255,0.1)`, `box-shadow: 0 8px 32px`, `border-radius: 20px`, increased body font-size to 0.9375rem with line-height 1.65

### [2026-04-11] — Hero image resized on Sales Agent page (salesagent.html)
- `.sa-hero-visual-inner`: `width` 110% → 80%, `max-width` 960px → 580px
- `.sa-hero-visual`: `margin-right` -10vw → -4vw, `justify-content` → flex-end for better balance
- Image now proportionate to left-hand headline text

### [2026-04-11] — Medihub Pharmacy carousel image replaced with new screenshot (salesagent.html)
- Old image: `uploaded-asset-1775895160015-0.png`
- New image: `uploaded-asset-1775896085700-0.png` (Medihub — "Serving the Community in Pontarddulais & Killay", pink chatbot widget open)

### [2026-04-11] — Southdowns Pharmacy Group carousel image replaced (salesagent.html)
- Old image: uploaded-asset-1775652123368-0.png
- New image: uploaded-asset-1775895890217-0.png (full-page screenshot with "Ask Our Pharmacist" chat widget open, couple hero image)

### [2026-04-11] — Carousel footnote text visibility improved (salesagent.html)
- `.sa-live-clients-footnote`: color bumped from rgba(255,255,255,0.55) → 0.75, font-size 0.8125rem → 1rem
- Added `border-top: 1px solid rgba(20,184,166,0.2)` separator + top padding for visual breathing room
- Line-height + max-width added for comfortable reading

### [2026-04-11] — Arrow nav + dot indicators added to client carousel (salesagent.html)
- Added `← →` arrow buttons + progress dots below the carousel track
- Buttons live outside card area — zero conflict with hover-to-zoom effect
- Dots sync with drag-scroll; keyboard ArrowLeft/ArrowRight also supported
- `.sa-live-scroll-hint` text hidden (replaced by visual nav controls)

### [2026-04-11] — Medihub Pharmacy card image replaced with correct screenshot (salesagent.html)
- Old image: `uploaded-asset-1775894491439-1.png` (wrong placeholder)
- New image: `uploaded-asset-1775895160015-0.png` (Medihub site with pink "Ask Our Pharmacist" widget + dental suite hero)

### [2026-04-11] — Easy Clinic card image corrected to cream/terracotta/purple screenshot (salesagent.html)
- Old image: `uploaded-asset-1775894491428-0.png` (wrong — was showing a different layout)
- New image: `uploaded-asset-1775894721521-1.png` (correct Easy Pharmacy site with "Speak To Dilip" widget)

### [2026-04-11] — Live carousel: 6 cards, reordered, 2 new images (salesagent.html)
- Reordered to: Ealing, Easy Clinic, Superior, Malvern, Southdowns, Medihub
- Added Easy Clinic card (pos 2) with hosted image `uploaded-asset-1775894491428-0.png`
- Replaced Medihub placeholder with real screenshot `uploaded-asset-1775894491439-1.png`
- Both new cards have lightbox trigger enabled + LIVE badge; subhead updated to "Six" practices

### [2026-04-11] — Pricing text visibility + DFY copy update (index.html)
- `two-paths-price-note` (Card 1): color upgraded from gray-400 to #6b7280, weight 500 — now clearly readable
- `two-paths-price-muted` (Card 2): color upgraded; featured card override lifted from rgba 0.4 → 0.65
- DFY pricing text replaced: "Pricing depends on your practice size and goals." → ROI/investment range copy
- CSS-only change to Card 1 note + text+CSS change to Card 2 pricing block

### [2026-04-11] — "Which One Is You?" section copy updates (index.html)
- Card 1 (DIY): All 5 bullets replaced with Bing strategy, AI-optimised prompts, engagement templates, Ealing indexing protocol, lifetime access
- Card 2 (DFY): Final bullet "Dedicated account manager" → "Direct access to the team that built the system — not a junior account handler."
- Card 3 (Proof): Subhead updated; bullets replaced with Superior 50%, Ealing 300%, Miles Clinic £300k, Southdowns £200k; removed Hospital/South Downs line and "Recommended system" line

### [2026-04-11] — Problem/Solution section copy + icon rework (index.html)
- LEFT: overline→ "THE PROBLEM", new headline "ChatGPT Isn't Searching Google. It's Searching Bing.", single consolidated body paragraph replacing 4 lines
- RIGHT: overline→ "THE SOLUTION", Card 1 title→ "The Bing Advantage" with new bar-chart/upward-arrow SVG icon and Bing 87% research body copy
- Cards 2–4: updated body copy per brief; all icons, layout, and card styling unchanged

### [2026-04-10] — Added curved edges + tilt to hero image (index.html)
- `border-radius: 20px` for rounded corners
- `rotate(-2deg)` tilt on active state for a dynamic, non-static look
- Layered `box-shadow` for depth (20px/60px + 8px/24px)
- Hover lifts slightly and reduces tilt to -1° with deeper shadow

### [2026-04-10] — Removed radial gradient mask from hero image (index.html)
- Removed `-webkit-mask-image` / `mask-image` radial-gradient from `.hero-image-stack img`
- Also removed the mobile-breakpoint mask override at ≤768px
- Image now displays at full quality with no edge fade-out
- No other layout, structure, or content changes

### [2026-04-10] — Homepage hero image swapped to new attached version (index.html)
- Old image: uploaded-asset-1775810656815-0.jpeg
- New image: uploaded-asset-1775811251244-0.jpeg (phone + £480 booking + AI icons on dark navy bg)
- No layout, CSS, or structural changes — image-only swap

### [2026-04-10] — Hero image now visible on mobile + premium treatment (index.html)
- Removed `display: none` at ≤1024px — image now shows below hero text on tablet/mobile
- Full-width responsive at all breakpoints: 720px max desktop, 100% on mobile
- Softer border-radius progression: 24px → 20px → 16px across breakpoints
- Deeper multi-layer box-shadow with cubic-bezier entrance animation
- Left-hand hero content (title, subtitle, CTA buttons, stats) completely untouched

### [2026-04-10] — Homepage hero image swapped to 16:9 version (index.html)
- Old image: uploaded-asset-1775762532501-0.jpeg (ChatGPT/Mounjaro phone mockup, ~4:3)
- New image: uploaded-asset-1775810656815-0.jpeg (phone + £480 booking + AI platform icons, 16:9)
- `max-width` bumped 520px → 640px to fill hero right column at wider aspect ratio
- No layout or CSS structure changes beyond width tweak

### [2026-04-09] — Premium depth treatment on homepage hero image (index.html)
- Replaced flat 3-layer shadow with 5-layer progressive shadow stack for realistic depth
- Border-radius bumped 16px → 20px for softer, more premium feel
- Added faint `rgba(255,255,255,0.08)` border for subtle edge definition
- Hover: gentle -4px lift + deepened shadow instead of scale-up
- No structural/layout changes — CSS-only refinement

### [2026-04-09] — Homepage hero image replaced with ChatGPT/Mounjaro phone mockup (index.html)
- Old images: uploaded-asset-1772985250408-0.jpeg + uploaded-asset-1773039341550-1.png (two-image stack with scroll swap)
- New image: uploaded-asset-1775762532501-0.jpeg (ChatGPT recommending Superior Pharmacy, phone + floating client logos)
- Removed second stacked image — now single image, max-width 520px, centred
- Cleaned up absolute positioning for single-image layout

### [2026-04-09] — Hero image replaced with phone/logo mockup (salesagent.html)
- Old image: uploaded-asset-1774942910672-0.jpeg (laptop/multi-device mockup)
- New image: uploaded-asset-1775739434759-0.jpeg (phone showing £480 booking + client logo cards floating around it)
- No layout or CSS changes — same `.sa-hero-visual-inner img` container

### [2026-04-08] — Carousel scroll fix + footnote readability (salesagent.html)
- Added full mouse drag-to-scroll and touch swipe JS to `.sa-live-carousel-track`
- Scroll hint text opacity: 0.25 → 0.55; footnote opacity: 0.3 → 0.55
- Both lines now clearly readable against dark navy background

### [2026-04-08] — Lightbox added to Live Right Now carousel (salesagent.html)
- Clicking any card screenshot opens a full-size lightbox overlay (blur backdrop, scale-in animation)
- Close via ✕ button, click outside, or Escape key
- Drag-threshold guard prevents lightbox firing after carousel scroll drags
- Medihub placeholder card has no trigger (no image yet)

### [2026-04-08] — Carousel image fixes: cropping + Southdowns image (salesagent.html)
- `object-position` changed from `top center` → `top right` so chatbot widgets on right side are visible
- Southdowns card: replaced Intelligence Engine chat image with correct full-page screenshot (uploaded-asset-1775652123368-0.png)
- New hosted images: -1775652123368-0.png (Southdowns full page), -1775652123377-1.png (spare)

### [2026-04-08] — "Live Right Now" client carousel added (salesagent.html)
- New dark-navy section inserted directly after the logo bar, before the problem section
- 5 cards: Ealing, Southdowns, Malvern, Medihub (placeholder pending screenshot), Superior Pharmacy
- Horizontal scrollable carousel: cards 420px wide, 260px screenshot area, fade-edge masks, drag-scroll
- Each card has "Live" teal pulse badge; footnote: "All chatbots live and patient-facing. Screenshots taken April 2026."
- Images: uploaded-asset-1775651904621-0.png (Ealing), -626-1.png (Malvern), -635-2.png (Superior), 1775650226952-0.jpeg (Southdowns)

### [2026-04-08] — Intelligence Engine image size fixed (salesagent.html)
- `max-width` reduced from 900px → 480px on the Southdowns chat image
- Added responsive breakpoints: 380px at ≤900px, 100% at ≤480px
- Root cause: previous swap kept the old `.sa-chatbot-hero-image img` 900px constraint

### [2026-04-08] — SalesAgent Intelligence Engine chat image replaced (salesagent.html) [v2]
- Old image: uploaded-asset-1775647874874-0.jpeg (travel vaccines family booking)
- New image: uploaded-asset-1775650226952-0.jpeg (Ask Our Pharmacist — Southdowns chat UI)
- No layout, CSS, or structure changes

### [2026-04-08] — SalesAgent eligibility section text readability fix (salesagent.html)
- `.sa-eligibility-note` and `.sa-eligibility-sub-cta` color: gray-400 → gray-600
- Affects italic note + "Takes two minutes. No obligation." line — both were near-invisible
- No structural changes

### [2026-04-08] — SalesAgent "Not For Everyone" copy updated (salesagent.html)
- Headline → "If Your Practice Meets These Three Criteria, There Is Five-Figure Monthly Revenue You Are Not Capturing."
- Card 1 body → converts visitors already leaving without booking
- Card 2 body → lists services, patients searching + willing to pay framing
- Card 3 body → brand trust angle, "before they've ever spoken to your team"

### [2026-04-08] — SalesAgent logo bar enlarged (salesagent.html)
- Logo height bumped 50px → 65px (desktop), 40px → 50px (mobile)
- Homepage logo bar is 50px — SA page now visually larger/more prominent
- Extra padding + label text was making same-size logos feel smaller

### [2026-04-08] — Ealing "The Method" section copy updated (case-study-ealing.html)
- Headline → "Boots Has a £2bn Marketing Budget…" framing
- Subhead → references ChatGPT/Claude/Google AI recommendation logic
- Final bullet in "What Sachin Did" → "Built for AI recommendation, not just Google indexing"
- All other bullets and "Most Practices" card left unchanged

### [2026-04-08] — Ealing "While You Wait" section reworked (case-study-ealing.html)
- Replaced 4 generic urgency cards with single centred narrative block telling Sachin's story
- New overline "WHILE YOU WAIT", headline "This Is What Was Happening to Ealing Travel Clinic"
- Three paragraphs of Ealing-specific copy about invisible demand and missed patients
- Teal gradient divider + bold closing line: "Three months later, he was doing 55 a month"
- Removed "Tomorrow it happens again" tagline entirely

### [2026-04-08] — Ealing hero image sizing fix (case-study-ealing.html)
- Constrained Sachin portrait: max-width 380px, max-height 460px with object-fit:cover
- Grid rebalanced from 1fr/1fr to 1.2fr/0.8fr — text side gets more space
- Decorative border accent scaled down proportionally (20px→14px offset)
- Mobile max-width reduced from 500px→340px for phone screens

### [2026-04-08] — Ealing Transformation Timeline: readability + impact overhaul (case-study-ealing.html)
- Before numbers: 2rem→3rem, opacity 0.25→0.45 — now clearly visible but still muted
- After numbers: 3rem→4.5rem with teal text-shadow glow — dramatic and unmissable
- Reframed first metric from "30→90 clicks/day" to "~900→2,700 clicks/month" — far more impressive
- Increased card padding, arrow width, tag size, context text size for premium feel
- Mobile responsive sizes bumped proportionally (2rem before, 3rem after)

### [2026-04-08] — Ealing Case Study: Before/After → Transformation Timeline (case-study-ealing.html)
- Replaced flat Before/After two-card section with dark immersive transformation timeline
- Three metric rows with animated counters, gradient arrows, multiplier tags
- Closing statement card: "The clinic didn't change. The visibility did."

### [2026-04-08] — Ealing Case Study: rankings section → proof cards (case-study-ealing.html)
- Replaced leaderboard rows with two side-by-side proof cards on dark background
- Card 1: Ealing Travel Clinic — 8→55 HPV vaccinations/month, £300/course revenue copy
- Card 2: The Bigger Picture — 300% revenue growth, compounding services narrative
- Removed "£4,200/month" bottom line; new overline "THE REAL RESULT"
- Premium styling: teal top accent bar, hover lift, responsive single-column on mobile

### [2026-03-31] — SalesAgent: hero image replaced, hover removed, pixel-perfect (salesagent.html)
- Swapped hero image to new uploaded asset (uploaded-asset-1774942910672-0.jpeg)
- Removed all hover/zoom behaviour (scale, teal border, zoom-hint badge)
- Removed border-radius, box-shadow, overflow:hidden, cursor:zoom-in from .sa-hero-visual-inner
- Image renders at natural resolution with zero CSS constraints — pixel perfect

### [2026-03-31] — SalesAgent: chat image rendering quality fix (salesagent.html)
- Replaced `filter: drop-shadow()` with `box-shadow` — drop-shadow forces GPU compositing and blurs text
- Added `image-rendering: -webkit-optimize-contrast` / `crisp-edges` to prevent browser interpolation softening
- Increased max-width from 680px → 900px so image doesn't have to stretch as much
- Root cause noted: source image is low-res; re-uploading at 2x (1800px+) is the definitive fix

### [2026-03-31] — SalesAgent: chat image enlarged in Intelligence Engine section (salesagent.html)
- Removed 2-col grid (420px column was making image too small to read)
- Layout now stacks vertically: copy on top, image below at full-section width
- Image max-width raised from 420px → 680px; text now legible
- Mobile: max-width 100% so it fills the viewport

### [2026-03-30] — SalesAgent: hero image bleed + zoom-on-hover enhanced (salesagent.html)
- Bleed increased from -6vw to -10vw; container width 110%, max-width 960px (was 820px)
- Hover zoom increased from 1.07 to 1.15 — enough to read UI detail in laptop screen
- Added "Hover to explore" hint badge (fades on hover) so users know to interact
- Teal border on hover strengthened to 2px / 0.35 opacity

### [2026-03-30] — SalesAgent: logo bar size + label readability fix (salesagent.html)
- Logo height bumped 42px → 50px to match homepage logo bar
- Opacity raised 0.55 → 0.7, hover 0.9 → 1 (matching homepage)
- Label text: font-size 0.65rem → 0.75rem, color opacity 0.35 → 0.55 for readability
- Mobile logo height 32px → 40px

### [2026-03-30] — SalesAgent: logo scroller v3 — flat single-row fix (salesagent.html)
- Previous twin-track nested approach still showed white gap on loop reset
- Flattened to match homepage pattern: single `.sa-logo-bar-scroller` div with 18 imgs (9+9 duplicate)
- Removed `.sa-logo-bar-track` wrapper entirely; animation now on `.sa-logo-bar-scroller` directly
- 30s duration, `translateX(-50%)`, same seamless loop as homepage-v2.html

### [2026-03-30] — SalesAgent: removed trust bar + fixed logo scroller (salesagent.html)
- Deleted entire `.sa-trust-bar` section (too cluttered sitting above the logo bar)
- Removed `uploaded-asset-1773216983562-1.png` (Puri Pharmacy photo/laptop image) from all 4 logo scroller duplicates
- Logo scroller now only shows 3 proper vector logos: Superior Pharmacy, Ray Lane Group, Ealing Travel Clinic
- Logo bar now sits cleanly directly below the hero with no stat bar above it

### [2026-03-30] — SalesAgent: sliding logo banner added after trust bar (salesagent.html)
- New `.sa-logo-bar` section placed between trust bar and SalesAgent Pro section
- Infinite scroll animation (28s), grayscale logos at 55% opacity, full colour on hover
- Logos: Superior Pharmacy, Ray Lane Group, Ealing Travel Clinic, Puri Pharmacy (×4 for seamless loop)
- Fade mask edges via ::before/::after gradients; pause-on-hover; responsive mobile sizing

### [2026-03-30] — SalesAgent: process section redesigned (salesagent.html)
- Replaced old 2-column "Four Weeks" layout with centred dark vertical 3-step design
- New headline: "Seven Days To Go Live. Bookings Before You've Had Your Morning Coffee."
- Steps: Train → Test → Deploy with user-provided copy, vertical connector lines, hover effects
- Added Day 1 → Day 7 animated timeline bar at bottom with teal gradient fill on scroll
- Removed old week-tab auto-cycling JS, replaced with simpler timeline reveal observer

### [2026-03-30] — SalesAgent: hero image replaced (salesagent.html)
- Swapped old hero device mockup image for new screenshot showing SalesAgent Pro chat, prompt library, AI checklist, and client logos
- Hosted new image via host_assets, updated src + alt text in .sa-hero-visual img

### [2026-03-30] — SalesAgent: flywheel steps 3+4 emoji → SVG icons (salesagent.html)
- Replaced ✍️ (step 3) with clean document/lines SVG icon matching indigo colour scheme
- Replaced 🚀 (step 4) with magnifying-glass-plus SVG icon matching green colour scheme
- Added `.sa-flywheel-icon svg` styles (28px, stroke-width 1.8, currentColor)
- Steps 1 (💬) and 2 (🧠) kept as-is per user preference

### [2026-03-30] — SalesAgent: Not A Chatbot → Intelligence Engine with Content Flywheel (salesagent.html)
- Reframed section from "we answer questions" to "every question is a revenue signal"
- Each query card now has 3rd layer: Content Signal (amber) showing exact blog post generated from patient question
- Added Content Flywheel 4-step visual loop: Capture → Intelligence → Content → AI Search Rankings
- Flywheel has spinning ↻ loop indicator, colour-coded step icons, responsive grid layout
- Closing line changed to "Every patient who asks a question is telling you what content to create next"

### [2026-03-30] — SalesAgent Pro: dashboard strip → revenue proof bar (salesagent.html)
- Removed cheesy "System Live" pulsating dot and monospace dashboard strip
- Replaced with 3-column revenue proof bar: £200k+ South Downs, 50% Superior, 1-in-4 Ealing
- Cream-white (#f0ede6) numbers on dark glass cards — revenue-focused, not generic metrics
- Subtle hover states, responsive stacking on mobile, italic "Real client results" context line

### [2026-03-30] — SalesAgent Pro: copy overhaul with real numbers (salesagent.html)
- Story rewritten: specific patient scenario (Mounjaro + blood pressure), 11-second competitor response, "never comes back" punchline
- Punchline updated from "South Downs 100+" to "100,000+ patient conversations across our network"
- First stat card: 100+ → 100,000+ patient conversations generated across network
- Dashboard strip: 247 handled this week → 2,847 handled this month (matches scale)

### [2026-03-30] — SalesAgent Pro section: premium redesign (salesagent.html)
- Body text → cinematic micro-story with teal left border, line-by-line pacing, punchline treatment
- Stat card 1: ring glow animation with pulsing outer ring
- Stat card 2: visual comparison bar (industry 2-5% vs ours 25%) with animated fills
- Stat card 3: "Running now" live pulse dot indicator
- Callout → live dashboard strip (System Live dot, 247 handled, 100% rate, 0 missed)

### [2026-03-30] — SalesAgent: problem → SalesAgent Pro showcase section (salesagent.html)
- Replaced generic "Built To Inform, Not Convert" with ChatGPT-referral narrative headline (3-line dramatic)
- Subhead now tells 10pm patient story anchored to South Downs capturing 100+ patients monthly
- Stats: teal numbers (100+ monthly patients, 25% conversion, Set & Forget) with sub-labels
- Added teal proof callout box: "Hundreds of inquiries monthly. Every single one handled."
- Added "See The System →" CTA button below callout

### [2026-03-30] — SalesAgent: client name-drops in hero, trust bar, problem (salesagent.html)
- Hero subtitle now names Superior Pharmacy (50% weight loss via AI), Ealing Travel Clinic (1-in-4 conversion), Ray Lane Group (24/7 no extra staff)
- Trust bar: each of 4 columns now anchored to a named client — Ealing 25%, Superior 50%, Ray Lane 24/7, Network 100k+
- Problem section: added italic proof callout naming Superior Pharmacy's after-hours revenue loss
- Matches homepage pattern (Sachin testimony) — specificity before the ask, not generic claims

### [2026-03-30] — SalesAgent hero: reduced text + premium trust bar (salesagent.html)
- Hero title downsized clamp(2.75rem,5.5vw,4rem) → clamp(2.25rem,4.5vw,3.25rem), subtitle 1.15→1.05rem, tighter spacing
- Killed weak inline trust stats (sa-hero-trust) — replaced with full-width dark navy trust bar between hero & problem
- Trust bar: 4-column grid (25% rate, 100k+ convos, 24/7, industry avg), staggered fade-in, teal top-line gradient
- Count-up animations on trust bar numbers, responsive 2-col on mobile, vertical dividers between items
- Matches homepage premium visual weight — no more text-heavy bottom of hero

### [2026-03-30] — SalesAgent Pro premium overhaul (salesagent.html)
- Complete redesign to match homepage billion-pound aesthetic: full-height hero, ambient glows, glassmorphism
- Hero: full viewport height, escalating title animation, trust stats bar, breathing device mockup — mirrors index.html hero exactly
- Problem: condensed to 1 paragraph + 3 stat cards (glassmorphism dark cards with count-up animations) — no more text wall
- Not A Chatbot: trimmed to 1-line intro → straight to query cards — visual-led not copy-led
- Proof: 2×2 grid matching homepage revenue cards (teal accent strips, ambient glows, backdrop blur, number pulse)
- How It Works: rebuilt as homepage method section — left anchor column with timeline widget + right step column with circle nodes, connector lines, proof badges
- Eligibility: 2-column layout with proper bordered cards (icon + title + desc) instead of plain ticks
- Final CTA: dark navy, matches homepage CTA treatment
- Count-up animations on all numeric stats, timeline auto-cycle, scroll-triggered reveals throughout

### [2026-03-30] — Sync PharmoBoost nav across all pages (ai-domination-system.html, case-study-ealing.html, homepage-v2.html)
- Replaced old nav markup + CSS on all 3 sub-pages with the new PharmoBoost dropdown from index.html
- Each page now has: PharmoBoost ▼ dropdown (7 products, 2 sections), Pharmacies, Clinics, Case Studies, The Playbook, Book A Call CTA
- Added dropdown CSS (hover reveal, arrow, white card, teal hover), mobile hamburger + overlay with accordion
- Consistent nav experience across entire site — no more stale links on inner pages

### [2026-03-30] — Navigation overhaul with PharmoBoost dropdown (index.html)
- Replaced old nav links with: PharmoBoost ▼, Pharmacies, Clinics, Case Studies, The Playbook, Book A Call
- PharmoBoost dropdown: 2 sections (Complete Packages / Custom AI Arsenal) with 7 products, hover teal bg, clean divider
- Clean white dropdown with arrow indicator, smooth opacity/transform reveal on hover
- Mobile: hamburger button toggles full-screen overlay with collapsible PharmoBoost accordion
- Framework names shown as lighter subtext below each product name

### [2026-03-30] — Revenue section: gold → teal accent consistency fix (index.html)
- Replaced all #c9a95c / #e2c97e gold references with teal (#14b8a6 / #2dd4bf) to match homepage palette
- Affected: ambient glow, eyebrow colour, headline underline, left-edge card strips, dividers, hover shadows, featured card shadows
- Section now visually consistent with hero, problem/solution, shift, pathway, and founder sections

### [2026-03-30] — Founder section copy polish + LinkedIn line (index.html)
- Body text split into 3 visual paragraphs via `.founder-body-break` spans (margin-top 1.25rem)
- Increased body line-height 1.75→1.8, bottom margin 1.25rem→1.5rem, last-of-type 2rem→2.5rem
- Added `.founder-linkedin` link below name/title: LinkedIn brand-blue icon, muted dark text, opens new tab
- LinkedIn line gets own scroll-reveal at 0.85s delay
- Link: https://www.linkedin.com/in/drew-s-clayton/

### [2026-03-30] — Founder section added above revenue results (index.html)
- New `.founder-section` with warm cream #FAF8F3 bg, 2-col grid (45/55 split)
- Left: Drew full-length transparent photo, bottom-aligned, bleeds to section edge
- Right: eyebrow/headline/body/name vertically centred with generous left padding
- Scroll-triggered reveals: copy staggered fadeUp, image slides in from left
- Mobile: stacks vertically (copy first, then photo full-width)
- Responsive breakpoints at 900px and 480px

### [2026-03-30] — FAQ section premium overhaul → dark navy glassmorphism (ai-domination-system.html)
- Moved from cream bg to navy bg with radial ambient glows
- Individual separated cards (gap 0.875rem) with glassmorphism: rgba white bg, subtle borders
- Added numbered teal badges (01–08) per question with active state fill
- Question text bumped 1rem → 1.1875rem Inter 700, white on dark
- Open state: teal glow border + shadow, answer text 1.0625rem with generous padding
- Toggle icon: 36px circle, teal transform on open, hover states
- Added bottom CTA section with teal button after FAQ list
- 3 responsive breakpoints (768px, 480px) — num badges hide on mobile

### [2026-03-30] — Timeline "What Happens Next" → Frank Kern style overhaul (ai-domination-system.html)
- Widened container 860px → 1000px, bigger headline clamp(2.25rem,4vw,3.25rem)
- Each step now a white card with 4px teal left border, hover lift + shadow
- Circle nodes: 52px → 80px with teal border, shadow ring, 1.75rem bold numbers
- Titles 1.0625rem → 1.5rem, body 0.9375rem → 1.125rem, labels 0.65rem → 0.8rem
- Step 6 (final) gets navy card treatment with teal accents — destination feel
- Full-height teal gradient connector line behind cards
- Responsive: 3 breakpoints (768px, 480px) with scaled-down circles/text

### [2026-03-30] — Tier cards, timeline & early buyers section size upgrade (ai-domination-system.html)
- Widened `.system-inner` from 1000px → 1200px so 3-col tier cards breathe
- Tier card titles 1.1875rem → 1.375rem, list items 1.0625rem → 1.125rem
- FREE badge: bigger (0.8rem), bolder (800 weight), more padding
- Value strap: text 1.125rem → 1.25rem, strong 1.25rem → 1.375rem, £497 1.375rem → 1.5rem
- Timeline stats 1.5rem → 1.625rem, labels 0.9375rem → 1.0625rem
- "Why Early Buyers Win": h3 clamp max 1.875rem → 2.25rem, body 1.0625rem → 1.1875rem, added margin-top 3rem
- Responsive fallbacks for mobile sizing

### [2026-03-30] — Revenue section: kill AI teal, warm premium typography (index.html)
- Replaced fluorescent teal gradient stats with warm off-white #f0ede6 — no gradients, no AI tell
- "In Real £." headline: dropped gradient teal, now white with subtle gold underline accent
- All accent colours shifted from teal → warm gold (#c9a95c) for left-edge bars, dividers, eyebrow, ambient glow
- Company labels bumped 0.65rem → 0.8rem, proof text 0.925rem → 1rem with stronger opacity
- Descriptors boosted to 700 weight / 1.125rem for more visual punch
- Mobile stat size tightened to 2.25rem for better fit

### [2026-03-29] — Premium revenue section billion-pound overhaul (index.html)
- Complete visual redesign: dark gradient bg, radial ambient glow, glassmorphism cards
- 2×2 card grid (was 4-col) — stats now huge (3.5rem) with room to breathe; £99k/year fits perfectly
- Left-edge gradient accent bars replace top borders; featured cards (2 & 4) get teal glassmorphism bg
- Headline "In Real £." gets gradient teal accent via `.revenue-headline-accent` span
- "Revenue." bolded in subheadline; eyebrow gets flanking teal lines
- Short teal gradient dividers per card; proof text muted for hierarchy
- CTA buttons enlarged (1.2rem padding, 12px radius); hover lifts with glow
- Fully responsive: stacks 1-col on mobile with adjusted stat sizes (2.5rem) and padding
- Count-up animation + staggered card reveals + number pulse preserved

### [2026-03-29] — Revenue cards visual hierarchy upgrade (index.html)
- Previous iteration: 4-col grid, top teal borders, checker pattern bg, nowrap stats

### [2026-03-29] — Animated "The Shift" section with dramatic staggering (index.html)
- Header: eyebrow → headline → subheadline stagger in with translateY reveals
- Comparison columns slide in from opposite sides (old from left, new from right)
- Google results load bar-by-bar with 0.1s stagger; later results fade to 0.45 opacity
- AI chat: user bubble slides in, response intro fades, 3 recommendations cascade with scale; #1 gets teal glow pulse
- Column captions fade up after their respective mockups complete
- Proof cards stagger up (2.8s → 3.0s → 3.3s); stat numbers pulse on reveal
- Competitor card gets ominous red glow pulse animation (2 cycles)
- Card hover: lift + enhanced shadow; competitor hover adds subtle red glow
- All driven by IntersectionObserver with `.shift-visible` class toggle

### [2026-03-29] — Animated Problem/Solution split section (index.html)
- Problem side: eyebrow, headline, and 4 text lines reveal staggered (0.1s–1.2s delays)
- "You don't." line gets emphasis treatment (larger, bolder, full white) on reveal
- Solution side: eyebrow fades, 4 cards stagger up with scale, icon glow pulse at 0.8s
- Card hover: teal accent border + elevated shadow + slight scale lift
- Teal CTA strip slides up when section enters viewport
- All driven by IntersectionObserver with `.split-visible` class toggle

### [2026-03-29] — Animated featured case study section (index.html)
- Added scroll-triggered reveal: image slides in from left with teal border draw-on effect
- Quote mark scales up, quote text fades up, author slides in — all staggered
- Stars cascade in one-by-one with spring physics (rotate + scale)
- CTA card rises from below; 300% number pulses on reveal
- Idle float animation on hero image after reveal completes
- All driven by IntersectionObserver with `.fcs-visible` class toggle

### [2026-03-29] — Premium headline typography refinement (index.html)
- Tightened .hero-title line-height from 1.15 → 1.08 (base), .line-2 → 1.02, .line-3 → 0.95
- Added negative letter-spacing -0.035em on .line-3 "Clients." for dense, weighted impact
- Compressed vertical gaps: .line-1 margin 0.04em, .line-2 margin 0.02em — headline reads as one unit
- Bumped .line-3 from 1.38em → 1.42em for stronger size punch
- Previous: split headline into 3 spans, staggered animations, reduced hero top padding 45px

### [2026-03-29] — Fixed full-width layout breakage below shift section (index.html)
- Missing closing `</div>` for `.shift-inner` and `</section>` for `.shift-section` after proof cards
- Caused "Which One Is You", case studies, stats, closing, and footer to nest inside `max-width: 1200px`
- Added the two missing closing tags to restore full-width layout

### [2026-03-29] — Improved pathway card trust banners (homepage-v2.html)
- Dropped all-caps → sentence case, bumped font-size from 0.6rem → 0.8rem
- Shortened copy: "Used by Superior, Ealing & Puri" / "Built for 50+ healthcare practices" / "Proof from pharmacies, clinics & hospitals"
- Increased contrast (darker green #2c5447 on light cards, 0.88 opacity on featured)
- Removed pipe-separated verbose strings that wrapped on smaller screens

### [2026-03-29] — Made pathway cards section full width (index.html)
- Removed inline `max-width:1200px` override and bumped `.two-paths-inner` from 1100px → 1400px
- Cards now match the width of hero, stats, and other full-width sections

### [2026-03-29] — Refined "Three Paths" section copy, banners & animations (index.html)
- Headline → "Which One Is You?" / subheadline → "Superior used the playbook. Ealing went done-for-you. Both outranked Boots."
- Banners: removed "USED BY:" labels, replaced with bolder proof statements (0.7rem, heavier weight)
- Card 2: removed price/retainer, replaced with italic muted "Pricing depends on your practice size and goals."
- Card 3 ticks: shortened to "Pharmacy:" / "Clinic:" / "Hospital:" prefix style
- Added scroll-triggered staggered entrance: Card 1 first, Card 2 rises 0.2s later with teal glow pulse, Card 3 last
- Hover: all cards lift + shadow; featured card adds teal border glow on hover

### [2026-03-29] — Upgraded "Two Paths" to "Three Paths" section (index.html)
- Expanded from 2-column to 3-column grid; Card 2 dark navy featured; Card 3 "By Practice Type" proof card
- Max-width 1200px, responsive stacks at 900px

### [2026-03-29] — Added "The Method" section to AI Search Playbook (ai-domination-system.html)
- New section between Level Playing Field and The System sections
- Two-column layout: sticky left anchor (headline + interactive week timeline) + right steps column
- Four numbered steps with scroll-triggered staggered reveals and active-state progression
- Interactive: clicking week blocks highlights corresponding steps; auto-activates on scroll
- Proof badges (teal pills) on steps 2 and 4 with client data
- Full CSS: navy background, teal accents, responsive (stacks on mobile, week blocks go horizontal)

### [2026-03-29] — Premium upgrade to V2 pathway cards + urgency section (homepage-v2.html)
- Pathway cards: added trust banners, ✓ feature lists, pricing anchors (£497 / £5k/month), rounded 24px cards with overflow hidden
- Featured card: teal pill RECOMMENDED badge, trust banner, structured features — matches original "Two Paths" quality
- Urgency comparison: upgraded from flat text-on-dark to premium card treatment with headers, tags (Winning/Losing), stat highlights, and losing-state footer
- VS divider: changed from inline text to floating teal circle badge overlay
- All copy preserved exactly per original build prompt

### [2026-03-29] — Major V2 homepage upgrade (homepage-v2.html)
- Hero: two-column split (55/45) with product mockup in rounded teal-tinted container, CTA buttons + inline stats bar
- Pathway cards: featured dark centre card with RECOMMENDED label, ~24px extra padding, flanking light cards
- Urgency: dramatic comparison with teal left-border accent, VS divider, ✓/✗ icons, italic closing challenge
- Final CTA: three distinct button styles (filled teal, teal outline, white outline), increased spacing
- Global: updated brand teal to #00B5A3, dark to #0D1117, generous section padding (100px), letter-spacing 4px on eyebrows
- Sections kept unchanged: logo bar, stats bar, proof carousel cards/images, footer

### [2026-03-29] — Added "Home Page 2" nav link across all pages
- Added `homepage-v2.html` link titled "Home Page 2" to nav in: index.html, homepage-v2.html, ai-domination-system.html, case-study-ealing.html
- Removed `__ANIMA_DBG__` debug log from case-study-ealing.html

### [2026-03-29] — Created alternative homepage v2 (homepage-v2.html)
- New file `homepage-v2.html` — hybrid router design with trust-first approach
- 7 sections: Hero, Trust Badges/Logos, 3 Pathway Cards, Urgency, Proof Carousel, Final CTA, Footer
- Matches existing design system: Inter/Outfit/Space Mono, navy/teal/cream palette, vanilla CSS
- Scroll-triggered reveal animations, card hover effects, carousel auto-scroll
- NO pricing on page — routes visitors to playbook, services, or verticals
- Original `index.html` untouched

### [2026-03-29] — Added sticky nav to homepage (index.html)
- Homepage was missing navigation menu that existed on case-study-ealing.html and ai-domination-system.html
- Added .nav CSS (sticky, backdrop-blur, 72px height) and HTML nav element before hero section
- Links: Case Studies, AI Search Playbook, Pricing, Get Free AI Report CTA
- Responsive: nav-links hidden on mobile (≤768px), brand always visible

### [2026-03-08] — Diagnosed hero image rendering differences
- User reported dots appearing on second hero image
- Investigated: dots are baked INTO the PNG file itself, not HTML elements
- Second image has gradient frame/border as part of the image file
- First image (JPEG) is clean mockup, second (PNG) has UI elements in export
- Solution: user needs to re-export or provide clean version of second image

### [2026-03-08] — Removed scroll dots, simplified to 2 hero images
- Deleted scroll-progress div and all scroll-dot elements from HTML
- Removed .scroll-progress and .scroll-dot CSS styles
- Cleaned up JS: removed dots array, dot click handlers, and debug logs
- Now only 2 images in hero stack (laptop mockup + pedestal display)

### [2026-03-08] — Fixed hero scroll-triggered image reveal
- Added new laptop mockup as first image (uploaded-asset-1772985250408-0.jpeg)
- Fixed scroll-progress dots appearing to right (added flex-direction: column to hero-visual)
- Adjusted scroll trigger zone for faster image transitions (~60% of hero scroll vs full height)
- Now 3 images: laptop mockup → pedestal display → original playbook image

### [2026-03-08] — Added mobile-specific hero headline
- Desktop: "National Chains Spend Millions. Still Lose to Our Clients."
- Mobile: "Big Brands Spend Millions. Still Lose to Us."
- Used .desktop-only / .mobile-only spans with display toggle at 768px
- Centered hero content on mobile for better readability

### [2026-03-08] — Updated Problem/Solution section copy and typography
- New problem headline: "Your Patients Are Finding Your Competitors"
- New body copy about Boots/Bupa appearing in AI answers
- Card 1: "We Build Better Content Than Anyone Else" (interactive guides)
- Card 2: "Rankings in Weeks, Not Months" (Ealing/Superior proof)
- Card 3: "Claude AI Specialists" (Claude Projects methodology)
- Bolder typography: headlines 700 weight, body 450 weight, generous line-height

### [2026-03-08] — Replaced bento grid with Problem → Solution split layout
- Left column (40%, navy): "THE PROBLEM" eyebrow, pain-point copy about invisibility
- Right column (60%, hero warm gradient): "THE SOLUTION" eyebrow, 2x2 card grid
- Cards: ChatGPT Tables, AI Overviews, Pillar Architecture, Conversion Tools
- Full-width teal CTA strip: "Rankings in weeks, not months" + button
- Mobile: stacks vertically, single-column cards

### [2026-03-08] — Implemented Bento Grid for "How We Get You Ranked" section
- Removed unauthorized bridge section (was added without user approval)
- Replaced boring 4-step horizontal process with bento grid layout
- Navy problem card (left, 2 rows): "Why Most Healthcare Practices Are Invisible"
- Four white feature cards (right, 2x2): ChatGPT tables, AI Overviews, Pillar architecture, Conversion tools
- Teal CTA strip at bottom with "Get Your Free AI Report" button

### [2026-03-08] — REMOVED: Bridge section (added without permission)

### [2026-03-08] — Simplified pre-headline to underline accent
- Removed pill/badge styling (background, border, border-radius)
- Added subtle 2px teal underline via ::after pseudo-element
- Underline at 60% opacity for editorial feel
- Kept Space Mono font, sage green color, fade-in animation

### [2026-03-08] — Enhanced hero pre-headline styling
- Bold weight (700), sage green (#4d7b6f), subtle pill background
- Added 1px border at 20% opacity, 20px border-radius
- Fade-in + slide-up animation (0.6s ease-out, 0.3s delay)
- Premium "reveal" effect draws attention without being gimmicky

### [2026-03-08] — Refined Sachin testimonial section
- Shortened quote: removed "We've worked with Drew..." preamble
- Added "How:" teaser line below meta text (AI-optimised content, zero ad spend, six weeks to #1)
- Updated CTA from "Click to read full story" to "See How We Did It →"
- Maintained teal highlighting on "300%" and "patients actually booking appointments"

### [2026-03-08] — Updated Sachin Mehta photo in case study section
- Replaced old image with new professional headshot (blue suit, white background)
- New hosted URL: uploaded-asset-1772980355727-0.jpeg

### [2026-03-08] — Refined hero left side with editorial typography
- New headline: "National Chains Spend Millions. Still Lose to Our Clients." with sage accent
- Typography: font-weight 500, letter-spacing +2%, line-height 1.15, dark navy (#1a2b3c)
- New CTAs: "Show Me Where I Rank" (primary) + "See The Proof" (outline with hover fill)
- Replaced trust badges with clean stats line: "£5M+ Revenue | 1000+ AI Rankings | 50+ Healthcare Clients"
- Mobile: stacked buttons, centered trust stats

### [2026-03-08] — Restored dual CTAs and trust badges in hero
- Added two buttons: "Get Your Free AI Report" (teal) + "View Case Studies" (white outline)
- Added trust badges row: Certified checkmark, ISO 27001, 5 Star Reviews, T40 Top Agency
- Styled outline button with white bg and 2px border for better definition
- Matches old design aesthetic from user's screenshot reference

### [2026-03-08] — Updated hero with provocative headline
- Pre-headline: "Your patients aren't just searching Google anymore"
- Headline: "ChatGPT Doesn't Care About Your Marketing Budget"
- Subhead unchanged (outrank Boots/Bupa messaging)

### [2026-03-08] — Simplified hero headline
- Changed from "AI Search Just Killed Brand Authority..." to "Patients Aren't Finding You. Here's Why"
- Shorter, more direct headline focused on patient problem

### [2026-03-08] — Updated hero copy with new messaging
- Pre-headline: "Your patients aren't searching Google anymore"
- Headline: "AI Search Just Killed Brand Authority. Independent Practices Are Finally Winning."
- New subhead about outranking Boots/Bupa, CTA "See Where You Rank (Free Report)"
- Added trust line below CTA, removed old trust badges (awaiting stats row)

### [2026-03-08] — Darkened featured case study background
- Changed from #faf9f7 to #f5f3f0 for more subtle contrast
- Still warm cream tone, just slightly darker for definition

### [2026-03-08] — Removed green tint from featured case study
- Deleted ::before pseudo-element with teal radial gradient overlay
- Section now has solid cream (#faf9f7) background, no pea-green tint

### [2026-03-08] — Cream CTA card in testimonial section
- Changed yellow CTA card (#fbbf24) to warm cream (#fcf4e9)
- Added subtle border for definition against cream section background
- Maintains visual continuity while keeping card distinct

### [2026-03-08] — Light background for testimonial section
- Flipped featured case study from navy to cream (#faf9f7) background
- Changed all text colors from white to navy/gray for readability
- Softened image shadow for light background context
- Added subtle borders for section definition
- Yellow CTA card and teal accents still provide visual interest

### [2026-03-08] — Proposed contrast solutions for case study section
- User concerned about stark jump from cream hero to navy case study
- Proposed 4 options: light bg flip, gradient bridge, intermediate section, softer navy
- Recommended light background approach for visual continuity
- New Sachin photo hosted, awaiting direction before implementation

### [2026-03-08] — Added premium case study section
- New full-width navy section after logo bar featuring Sachin Mehta testimonial
- Two-column layout: photo with teal border accent, quote with highlighted stats
- Yellow CTA card with 300% stat and link to case-study-ealing.html
- Follows design system: navy bg, teal accents, Outfit font, clean professional aesthetic

### [2026-03-08] — Warmer logo bar background
- Changed logo bar background from #faf9f7 to #fcf4e9
- User-specified hex code for warmer cream tone

### [2026-03-08] — Solid cream background for logo bar
- Changed logo bar from mint gradient to solid cream (#faf9f7)
- Restored subtle top border for clean separation from hero
- Matches site's overall cream background color

### [2026-03-08] — Matched logo bar to hero cream gradient
- Changed logo bar background to continue hero's mint (#ecfdf5) at top
- Gradient flows from mint → soft mint → cream for seamless transition
- Removed top border for cleaner hero-to-logo-bar connection

### [2026-03-08] — Proposed logo bar gradient improvements
- Analyzed hero gradient (#fef7ed → #ecfdf5) vs logo bar (#fdfcfa → #faf9f7)
- Suggested 5 options: continue mint flow, subtle mint tint, warm bookend, seamless blend, pure white
- Recommended continuing hero's mint for visual continuity

### [2026-03-08] — Warm gradient on logo bar
- Changed logo bar from stark white to soft cream gradient (180°)
- Gradient flows from #fdfcfa → #f9f8f6 → #faf9f7 for warmth
- Softened borders to rgba for subtler separation from hero

### [2026-03-08] — Added warm gradient to hero background
- Applied subtle 135° gradient from peachy cream (#fef7ed) to soft mint (#ecfdf5)
- Gradient flows warm-to-cool across hero section
- Maintains professional feel while adding visual warmth

### [2026-03-08] — Transparent logos and seamless infinite scroll
- Replaced logos with user's transparent PNG versions (Raylane, Superior, Ealing)
- Removed mix-blend-mode: multiply (not needed for transparent PNGs)
- Doubled logo duplicates (18 total) to eliminate white gap during scroll
- Added flex-shrink: 0 to prevent logo compression

### [2026-03-08] — Full-width logo bar below hero
- Converted logo scroller to full-viewport-width section
- White background with subtle top/bottom borders for distinction
- Removed heading, kept exact same image styling (grayscale, opacity, mix-blend-mode)
- Added more logo duplicates for smoother infinite scroll animation

### [2026-03-08] — Proposed hero alternatives
- User rejected floating cards and blobs as cheap
- Proposed 6 alternatives: typography-led, data viz, editorial photo, typographic animation, icon grid, bold statistic
- Awaiting user direction on preferred approach

### [2026-03-08] — Fixed hero image positioning
- Removed negative margins and translateX that pulled image left
- Centered image with justify-content: center, max-width 650px
- Enhanced shadow depth and added scale-up hover effect
- Added debug logs for interaction path verification

### [2026-03-08] — Enlarged and repositioned hero product mockup
- Increased image width to 95%, shifted left with negative margin and translateX
- Adjusted grid columns from 1.2fr/1fr to 1fr/1.1fr for better balance
- Reduced gap to 3rem, mockup now "comes forward" toward center
- Maintained premium shadows and hover effects

### [2026-03-08] — Added layered shadows and rotation to hero image
- Applied 1.5° rotation with 3-layer box-shadow for premium depth
- Added hover effect that straightens image and enhances shadow
- Increased border-radius to 12px for softer look

### [2026-03-08] — Added hero image (AI Search Playbook mockup)
- Hosted and integrated user's device mockup image into hero-visual container
- Added simple img styling with border-radius
- Image background blends with site's cream (#faf9f7) background

### [2026-03-08] — Removed AI Visibility Report from hero
- Deleted scorecard component from hero-visual container
- Left hero-visual div empty as placeholder for new image
- Hero left-side content (eyebrow, title, subtitle, CTAs, trust badges) unchanged

### [2026-03-08] — Premium scorecard redesign matching reference
- Full-width teal accent bar at top (not inset)
- Teal column headers (PLATFORM/STATUS/RANK) matching reference
- Layered box-shadow for premium depth effect
- Bolder practice name typography, refined location badge
- Removed icons from platform names for cleaner look

### [2026-03-08] — Awaiting clarification on Bupa implementation
- User requested implementation with "Bupa" instead of "sample dental practice"
- Searched project files; no existing "sample dental practice" text found
- Awaiting user clarification on what to implement

### [2026-03-08] — Added Space Mono font for hero eyebrow
- Loaded Space Mono from Google Fonts alongside Outfit
- Updated .hero-eyebrow to use Space Mono at 1.125rem, navy color
- Matches Medico Digital's monospace eyebrow treatment for technical authority

### [2026-03-08] — Clean professional redesign matching competitor aesthetic
- Removed ALL AI clichés: orbs, glows, gradients, glassmorphism, shimmer effects
- Cream background (#faf9f7), navy text (#0a1020), single accent color (teal)
- Outfit font, generous whitespace, simple typography hierarchy
- Expertise section with image/title/arrow grid layout like Medico Digital
- Clean cards with subtle borders, no hover transforms, restrained styling

### [2026-03-08] — Complete professional redesign of index.html
- Shifted from sage/terracotta to navy (#1e3a5f) professional palette
- Simplified hero with lead capture form as focal point
- Added clean header navigation, trust logos section
- Case study cards instead of sprawling sections, more whitespace
- Kept lead-gen focus with forms in hero and footer CTA

### [2026-03-08] — Competitor analysis for professional redesign
- Analyzed Medico Digital's design patterns vs current site
- Key findings: typography restraint, trust signals, color discipline, whitespace
- Recommendations: simplify hero, add trust logos, shift to navy palette, case study cards
- Awaiting user direction on implementation scope

### [2026-03-08] — Investigated error report
- User reported an error; reviewed index.html structure (1289 lines)
- Verified JS at end of file only references `aiRankingForm` and `lucide.createIcons()`
- No obvious broken references found after nav removal; awaiting error details

### [2026-03-08] — Removed navigation menu from index.html
- Deleted entire `<nav>` element (lines 166-237) including desktop and mobile menus
- Removed mobile menu JavaScript toggle code
- Adjusted hero section padding from `pt-32` to standard `py-20` (no fixed nav offset needed)
### [2026-03-08] — Replaced hero hexagons with AI Visibility Scorecard
- Removed floating hexagon shapes and connecting lines
- Added clean scorecard mockup showing Platform/Status/Rank table
- Sample data with ChatGPT, Claude, Perplexity, Google AI rows
- Highlighted "Your Practice: ?" row creates curiosity gap
- Clean white card, subtle shadow, 2° rotation, no AI effects

### [2026-03-08] — Added client logos to logo bar
- Hosted 3 pharmacy logos: Superior, Southdowns, Raylane
- Added mix-blend-mode: multiply to blend light backgrounds into cream
- Increased logo height to 50px, opacity to 0.6 for better visibility
- Duplicated logos for infinite scroll animation

### [2026-03-08] — Updated hero accent color
- Changed .hero-title .accent from #4a7c6f to #1bb4a9
- Affects "Still Lose to Our Clients" text in hero headline

### [2026-03-09] — Removed accent color from hero headline
- Changed .hero-title .accent from teal (#1bb4a9) to dark charcoal (#1a2b3c)
- "Still Lose to Our Clients" now matches rest of headline
- All-dark typography for unified look

### [2026-03-09] — Removed hero eyebrow subheading
- Deleted "Your patients aren't searching Google anymore" pre-headline
- Hero now starts directly with main headline

### [2026-03-09] — Added Inter font to hero headline
- Loaded Inter from Google Fonts alongside Outfit and Space Mono
- Applied Inter to .hero-title with font-weight 700
- Changed letter-spacing from +0.02em to -0.02em for tighter tracking
- Matches user's reference screenshot aesthetic

### [2026-03-09] — Added hero animation sequence
- Two-part headline reveal: line 1 at 0.2s, line 2 at 1.3s (0.8s duration each)
- Subhead fades in at 2.3s, CTAs at 2.7s, trust stats at 3.0s
- All elements include subtle 12px slide-up with fade
- Total sequence ~3.5s, premium editorial feel

### [2026-03-09] — Swapped second hero image
- Replaced pedestal display image with new laptop + stats dashboard mockup
- New image URL: uploaded-asset-1773039341550-1.png
- Dots removed (were baked into old PNG, new image is clean)
- First hero image (AI Search Playbook laptop) unchanged

### [2026-03-09] — Updated Problem/Solution section copy
- Problem: shorter punchy lines ("You don't." / "Because you're invisible.")
- Card 1: 5+ minute engagement vs 30 seconds generic posts
- Card 2: "From Zero to Featured in 6 Weeks" with Ealing/Superior proof
- Card 3: "We Speak AI's Language" - built with Claude, ranked by Claude
- Card 4: "50% of Sales From ChatGPT" - Superior Pharmacy Mounjaro case

### [2026-03-09] — Fixed logo bar infinite scroll jitter
- Changed animation from `translateX(calc(-50% - 2rem))` to `translateX(-50%)`
- The `-2rem` offset was causing mismatch when animation looped back to 0%
- Now seamless transition as duplicate set aligns perfectly with start position

### [2026-03-09] — Updated Ealing Travel Clinic card in case studies carousel
- Replaced Unsplash doctor/patient image with new Google AI Overview screenshot
- Updated both carousel instances (original + duplicate for infinite scroll)
- Text content unchanged (already matched user's requirements)

### [2026-03-09] — Updated Ealing Travel Clinic carousel image
- Replaced Google AI Overview screenshot with new consultation room photo
- Updated both carousel instances (original + duplicate for infinite scroll)
- New image: travel clinic consultation with nurse and patient

### [2026-03-09] — Updated Ealing Travel Clinic carousel image (passport flat lay)
- Replaced consultation room photo with new travel health flat lay image
- Features passport, vaccination certificate, travel health kit, map, tablet
- Updated both carousel instances (original + duplicate for infinite scroll)
- New image: uploaded-asset-1773047932483-0.png

### [2026-03-10] — Replaced pharmacy pills image in case studies carousel
- Swapped Unsplash pills photo (photo-1585435557343-3b092031a831) with new ChatGPT/AI recommendation mockup
- New image: uploaded-asset-1773160539937-1.png (phone + laptop + OpenAI branding)
- Updated both carousel instances (original + duplicate for infinite scroll)

### [2026-03-10] — Added "The Shift" section
- New section between split-section+CTA and the existing CTA form
- Two-column comparison: Google search mockup (faded results/page 2) vs ChatGPT AI interface (Superior Pharmacy #1)
- Three proof cards: Superior Pharmacy (50%), Ealing Travel Clinic (300%), Your Competitors (urgency)
- Centered CTA block with dual buttons: "Get The Playbook — £497" + "See Where You Rank (Free)"
- Fully responsive, uses existing CSS variables/fonts (Inter, Space Mono, Outfit), matches design system

### [2026-03-10] — Awaiting user direction
- User indicated continuing from previous message
- Page loads correctly, reviewed index.html structure (2674 lines)
- Runtime debug session active, awaiting specific issue details

### [2026-03-10] — Swapped brain image in Private Hospital case study card
- Replaced Unsplash brain photo (photo-1559757148-5c350d0d3c56) with new prescription clipboard image
- New image: uploaded-asset-1773161251945-1.png
- Updated both carousel instances (original + duplicate for infinite scroll)

### [2026-03-10] — Fixed carousel image rendering for mockup/screenshot assets
- Added `.case-card-image.contain` CSS class: `object-fit: contain`, `padding: 0.75rem`, navy bg `#0f172a`
- Applied `contain` class to 3 custom images: travel flat-lay, ChatGPT mockup, prescription clipboard
- Unsplash photo cards (weight loss/medical) retain `object-fit: cover` behaviour
- Both carousel sets (original + duplicate) updated consistently

### [2026-03-10] — Reverted carousel images to object-fit: cover
- Removed `.case-card-image.contain` CSS class and all `contain` class instances from HTML
- All 8 carousel card image divs (4 original + 4 duplicate) now use default cover behaviour
- Deleted `.case-card-image.contain img` and hover override rules from CSS

### [2026-03-10] — Replaced expertise grid with "The Method" section
- Deleted `.expertise` section and all related CSS (`.expertise-inner`, `.expertise-card`, etc.)
- New `.method-section` matches "The Shift" section style: cream bg, same padding, centered header
- Four numbered cards (1–4) using exact split-card styling: white bg, 12px radius, same shadow/padding
- Number badges are sage green (#4d7b6f) circles with Space Mono font, matching eyebrow typography

### [2026-03-10] — Premium redesign of The Method section
- Replaced generic cream 2×2 card grid with full navy two-column layout matching brand system
- Left anchor: Space Mono eyebrow, Inter headline, proof copy, 3-week timeline bar widget
- Right steps: vertical connected timeline (4 steps) with connector lines, week labels, proof badges
- Step content now has real specificity: session durations, client names, AI platform details
- Fully responsive: stacks vertically on mobile with border separator between columns

### [2026-03-11] — Method section readability + scroll animation upgrade
- Timeline bar: bigger fonts (0.75rem nums, 0.7rem labels), stronger borders, +padding for legibility
- Timeline widget cycles automatically (every 2.2s) when not in view; stops when scrolled to
- Step circles: start dim/small (scale 0.85, opacity 0.4), animate to full teal on scroll via IntersectionObserver
- Step bodies (week label + title + text): fade+slide in from right as each step activates
- Connector lines: dim white → teal gradient fill when step above is active
- Body copy contrast: rgba(255,255,255,0.75) up from 0.6; proof-line opacity 0.82 up from 0.7
- Step titles: 1.125rem (up from 1.0625rem), font-weight 700; step circles: 52px (up from 48px)

### [2026-03-11] — Enlarged Typical Client Timeline widget
- Increased `.method-weeks` max-width from 380px to 100% (full column width)
- Bigger padding on week blocks: 1.75rem 1.25rem (up from 1.125rem 0.75rem)
- Larger week number font: 1rem (up from 0.8rem), week label: 0.9375rem (up from 0.775rem)
- Thicker border: 2px (up from 1.5px), larger border-radius: 14px (up from 12px)
- Mobile sizes also bumped proportionally

### [2026-03-11] — Replaced stats bar with story-driven proof section
- Removed 4-column number grid (300% | 50% | 100K+ | 212%)
- Left column (60%): navy card, "50% of Sales From ChatGPT" feature story for Superior Pharmacy
- Right column (40%): cream card, 3-section breakdown for Ealing (Problem / Result / Method)
- New CSS classes: `.proof-layout`, `.proof-feature`, `.proof-breakdown`, `.proof-stat-list`
- Fully responsive: stacks vertically on mobile ≤900px

### [2026-03-11] — Fixed ghost strip appearing above hero on live link
- Root cause: `.hero` had `padding: 4rem 2rem` creating dead space above content, body `background-color: #f5f3ef` differed from hero gradient start `#fef7ed`
- Fix 1: Removed hero top padding (changed to `padding: 0 2rem`), vertical centering already handled by `align-items: center`
- Fix 2: Changed `body` background to `#fef7ed` to match hero gradient start — seamless if any gap shows

### [2026-03-11] — Updated Private Hospital carousel card to Pharmacy
- Replaced prescription clipboard image with new pharmacy counter photo (uploaded-asset-1773216983562-1.png)
- Category: "PHARMACY", Headline: "#1 in UK for Mounjaro Provider"
- New description: local pharmacy beating national chains through better content
- Updated both carousel instances (original + duplicate)

### [2026-03-11] — Redesigned testimonial card: circular avatar layout (Option B)
- Removed big left photo panel entirely from `.testimonial-card`
- Quote-first design: large `"` mark → blockquote → 88px circular avatar + name/role row → badges
- Single-column card, max-width 900px, centred; clean white card with subtle border
- CSS rewritten: removed `.testimonial-image`, simplified `.testimonial-content`, added `.testimonial-quote-mark`

### [2026-03-12] — Added outcome-focused CTAs to carousel cards
- Each of the 4 card types now has a unique Frank-Kern-style CTA link below the description
- Ealing: "See exactly how they did it →" → links to case-study-ealing.html
- Superior / Weight Loss / Pharmacy: outcome-hooks linking to #contact
- Added `.case-card-cta` CSS: teal uppercase text, animated border-bottom + arrow nudge on hover
- Both carousel sets (original + duplicate) updated consistently

### [2026-03-12] — Expanded short carousel card descriptions for CTA alignment
- Added second sentence to "50% of sales from ChatGPT" card: "From launch to ChatGPT shortlist in under 4 weeks."
- Added second sentence to "Travel Clinic" card: "Zero ad spend—just better content, indexed faster."
- Updated both carousel sets (original + duplicate) consistently
- CTAs now visually aligned across all 4 cards

### [2026-03-12] — Fixed duplicate carousel card headline
- Weight Loss card: "#1 in UK for Mounjaro Provider" → "30,000 Patients a Year — Without Spending a Penny on Ads"
- Pharmacy card retains "#1 in UK for Mounjaro Provider" (stronger context for beating chains)
- Updated both carousel sets (original + duplicate) consistently

### [2026-03-12] — Updated pharmacy carousel card CTA
- Replaced "Beat the chains — book a free audit" with "Get this system for your practice"
- Updated both carousel instances (original + duplicate) consistently

### [2026-03-12] — Shortened Weight Loss carousel card title
- "30,000 Patients a Year — Without Spending a Penny on Ads" → "30,000 Patients a Year. Zero Ad Spend."
- Updated both carousel instances (original + duplicate) consistently

### [2026-03-12] — Added "Two Paths" section after Problem/Solution
- New `.two-paths-section` between split section and The Shift section
- Two equal cards: DIY (Playbook £497, teal CTA) + DFY (Full Implementation, outline CTA)
- Sage green labels (Space Mono), Inter headlines, feature checklists, price blocks
- Cream background (#FAF8F3), white cards, 24px radius, generous padding
- Mobile: stacks vertically (DIY on top)

### [2026-03-12] — Added proof banners to Two Paths cards + updated copy
- Added `.two-paths-proof-banner` strip at top of each card (sage green 18% opacity bg, Space Mono uppercase)
- Wrapped card contents in `.two-paths-card-inner` to handle padding correctly with banner
- DIY banner: "Used by: Ealing Travel Clinic | Superior Pharmacy | Puri Pharmacy"
- DFY banner: "Built for: Ealing | Superior | Puri | 50+ Healthcare Practices"
- Updated all copy: headlines, body text, feature bullets per spec

### [2026-03-12] — Added sage CTA band + updated footer content
- New `.cta-band` section (sage green #8B9D83) above footer: headline, 2 buttons, proof line
- Mobile: buttons stack vertically
- Footer left: PharmoDigital name, tagline, description, sage-green "Get Playbook" link
- Services column reordered: AI Search Playbook / Full Implementation / Healthcare Websites / Case Studies
- Company column updated: About Us / How It Works / Case Studies / Contact

### [2026-03-12] — Closing section background: sage → hero cream gradient
- Changed `.closing-section` background from `#8B9D83` to hero's `linear-gradient(135deg, #fef7ed → #ecfdf5)`
- Adapted all text for light bg: quote/name/mark colors → navy `#1a2b3c`, role → `#4b5563`
- Photo border: `rgba(255,255,255,0.8)`, softer shadow; badges gained subtle `border: 1px solid rgba(0,0,0,0.07)`

### [2026-03-13] — Updated "Ready to Start?" CTA section copy
- New headline: "Get Featured When Patients Ask ChatGPT for Healthcare Recommendations"
- New subheadline: specific 5-module proof with Ealing/Superior outcomes + 8-week timeframe
- New social proof line: "Used by 50+ healthcare practices. Zero require technical skills. All outrank national operators."
- Buttons and eyebrow kept unchanged

### [2026-03-14] — Created ai-domination-system.html sales page
- New standalone sales page following index.html design system 100% (no Tailwind, no Playfair)
- Same CSS variables: --navy, --teal, --cream, Space Mono eyebrows, Inter headlines, Outfit body
- Sections: Hero, Problem/Solution split, Proof (3 cases), Playing Field comparison, System (5 modules), Math, Timeline, FAQ accordion, Guarantee, Final CTA + price card
- FAQ uses JS accordion pattern; sticky price card; reuses proof images from index.html

### [2026-03-14] — Wired all "Get The Playbook" CTAs to sales page
- Updated 5 links in index.html: shift CTA block, Two Paths DIY card, CTA section, closing card btn, footer brand link
- All now point to ai-domination-system.html (previously pointed to #contact or #get-started)

### [2026-03-14] — Redesigned THE SYSTEM section for scannability
- Stripped all paragraph body text from 5 module cards — now: badge + title + 1-line subheadline + 3 checkmarks only
- Replaced `.system-module-output` tag badges with clean `.system-module-check-item` inline checkmark rows
- Collapsed "Everything You Get" from 3-column grid to single-column navy card with 3 sub-headers (Manual / Automated / Support)
- Removed `system-module-subheading`, `system-module-text`, redundant subtext paragraphs from CSS + HTML

### [2026-03-14] — Redesigned "Everything You Get" into 3 tier cards
- Replaced single navy dump with 3 side-by-side cards: Manual (white/sage), Automated (navy/teal), Lifetime (cream)
- Each card has: icon + title header, status pill (Available Now / 4 Weeks / + Free), highlighted key item
- Value strap banner below: "£497 total · Manual + Automated + Lifetime Support · No recurring fees"
- New CSS: `.system-tiers`, `.system-tier-card`, `.system-tier-header`, `.system-tier-status`, `.system-tier-value-strap`
- Mobile responsive: cards stack vertically below 900px

### [2026-03-14] — Implemented all 9 scroll-triggered motion enhancements on sales page
- 1: Hero stat countUp (300%, 50%, #1 UK animate from 0 on viewport entry, eased cubic)
- 2: Proof cases stagger reveal (image → result → how → quote, 200ms between each part)
- 3: Compare cards slide from opposite sides (Old Game ← left, New Reality → right, IntersectionObserver)
- 4: System modules cascade (100ms stagger, 5 cards fade+slide up sequentially on scroll)
- 5: Math section pulse (£108k red number scale 1.05→1.0 once, £497 teal glow/text-shadow bloom)
- 6: Timeline progressive activation (circles fill teal, connectors colour, body slides in from right)
- 7: Price card float (3px up/down, 3s cycle, only when in viewport, stops when scrolled away)
- 8: FAQ items cascade + answer opacity fade (items stagger 80ms, answer-inner opacity 0→1 with 150ms delay)
- 9: CTA arrow micro-interaction (→ arrow on 5 buttons, translateX(4px) on hover)
- All CSS: cubic-bezier(0.16,1,0.3,1) easing, no libraries. All JS: vanilla IntersectionObserver, ~160 lines

### [2026-03-14] — Reviewed ai-domination-system.html (no changes)
- Identified 9 motion enhancement opportunities; no code changes made per user request

### [2026-03-14] — Redesigned "The Numbers" section on sales page
- New headline: "What This Actually Means for You" with intro paragraph
- Replaced old 3-row comparison cards with 4 audience cards (Practice Owners, Marketing Managers, Multi-Practice Groups, Agencies & Consultants)
- Simplified comparison: 2-row Old Way (£5k/month, £60k/year) vs New Way (£497 once, £497 total)
- Added centered difference callout: "You keep £59,503 and own the IP"
- Kept closing navy callout: "One new patient per month pays for this"

### [2026-03-14] — Elevated "What This Actually Means for You" audience cards
- 4 cards now each have distinct visual identity: navy, white, sage, cream backgrounds
- Added bold metric anchors (£497 vs £60k, Career Move, 1 → Unlimited, 120x ROI)
- Space Mono eyebrow labels per card; refined headlines with sharper copy
- Staggered IntersectionObserver reveal (120ms cascade, 28px slide-up)
- Subtle hover lift (translateY -3px); responsive at 768px breakpoint

### [2026-03-14] — Fixed proof section profile picture rendering
- Sachin (Ealing): was cutting off face — added `object-position: center top` via inline style
- Raman (Superior): `.portrait` CSS class used `object-fit: contain` + dark `#111827` bg → no border-radius
- Fixed `.portrait` to use `object-fit: cover` + `object-position: center top`, removed dark background
- Both images now show faces correctly, consistent rounded corners, no navy fill

### [2026-03-14] — Swapped Raman photo on sales page proof section
- Replaced tight-cropped `uploaded-asset-1770377675731-1.png` with better-framed `uploaded-asset-1773224605645-0.png`
- New image is the same one used in index.html closing section (shoulders-up, proper framing)
- Removed now-redundant `.portrait` CSS class and its rules
- Added `object-position: center top` inline style to match Sachin card treatment

### [2026-03-15] — Rebuilt SC proof section: fixed image heights + improved captions
- Root cause: images had different natural heights → caption text floated at different Y positions
- Fix: added `.sc-proof-img-wrap` with fixed `height: 260px`, `object-fit: cover`, `object-position: top center`
- Caption redesigned: 3-tier layout — `.sc-proof-caption-name` (bold headline) + `.sc-proof-caption-result` (readable sentence) + `.sc-proof-caption-data` (Space Mono data line)
- Both cards now visually aligned and text is legible at proper size

### [2026-03-15] — Removed South Downs Pharmacy proof case from sales page
- Deleted entire third `.proof-case` block: conversion dashboard card, client row, result, how, and AI agent note
- Proof section now shows only Ealing Travel Clinic and Superior Pharmacy cases

### [2026-03-15] — Replaced proof-callout stats box with Bing rankings screenshot
- Deleted `.proof-callout` CSS and HTML (2 hrs / 1 hr / 2–6 wks stats block)
- Added `.proof-bing-wrap` with full-width image display
- New image: superiorpharmacy.co.uk #1 Bing result for UK Mounjaro Provider Comparison
- Dark navy section context preserved; image has subtle border + deep shadow

### [2026-03-15] — Complete rebuild of case-study-ealing.html
- Stripped Tailwind CSS, Playfair Display, sage/terracotta color scheme, organic-card classes, blur blobs
- Rebuilt with exact design system from index.html + ai-domination-system.html: vanilla CSS, Inter/Outfit/Space Mono, navy/teal/cream
- Sections: Hero (stats row), Problem (navy callout), Discovery, Proof Screenshot (navy bg), Mechanism (compare cols), Results (stat cards + keywords grid), Rankings (navy bg), Quote, Before/After, Urgency (navy), CTA (two cards), Footer
- Added IntersectionObserver reveal animations (`.reveal` + `.stagger-*`), matching sales page motion patterns
- Nav and footer are pixel-identical to other pages; all CSS is inline, no Tailwind dependency

### [2026-03-15] — Updated Superior Pharmacy proof copy on sales page
- Result: added "and Bing combined" to 50% of sales stat
- How: replaced "Page 1" with "#1 on Bing", explained Bing→ChatGPT feed mechanism
- Added second paragraph: Bing conversion quality + competitor names (Juniper, SHEmed, Pharmacy Express)

<!-- NEXT_ENTRY_HERE -->
</changelog>
