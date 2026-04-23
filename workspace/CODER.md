<instructions>
This file will be automatically added to your context. 
It serves multiple purposes:
  1. Storing frequently used tools so you can use them without searching each time
  2. Recording the user's code style preferences (naming conventions, preferred libraries, etc.)
  3. Maintaining useful information about the codebase structure and organization
  4. Remembering tricky quirks from this codebase

When you spend time searching for certain configuration files, tricky code coupled dependencies, or other codebase information, add that to this CODER.md file so you can remember it for next time.
Keep entries sorted in DESC order (newest first) so recent knowledge stays in prompt context if the file is truncated.
</instructions>

<coder>
# File Content Goes Here

## Nav Structure Reference (index.html — pending propagation to other 5 pages)
- **Nav layout**: `.nav-inner` uses `grid-template-columns: 1fr auto 1fr` — three-column centred logo
- **Nav classes**: `.nav` (sticky), `.nav-inner` (grid), `.nav-brand` (centred logo, row 1), `.nav-links` (left, row 2), `.nav-links-right` (right, row 2 — CTA only), `.nav-hamburger` (mobile ≤768px), `.nav-mobile-overlay` (mobile menu)
- **Left nav items**: Two `.nav-dropdown` triggers — "Who We Help" (Pharmacy Groups / Private Clinics / Enterprise Healthcare) and "Our Work" (The Build / The Agent / The Method)
- **Right nav items**: "The Proof" dropdown (CLIENT RESULTS + LATEST BUILDS), plain "About" link, "Join The Waitlist" CTA
- **Dropdown styling**: `.dd-section-label` colour is `var(--gildhart-gold)`, divider between categories uses gold with `opacity:0.25`
- **Logo img**: `uploaded-asset-1776767932323-0.png` at 150px max (desktop), 120px tablet, 80px mobile
- **All 6 pages**: unified nav propagation COMPLETE (index, homepage-v2, ai-domination-system, case-study-ealing, salesagent, web-pro-elite)

## Nav Fixed + Spacer (all 6 pages)
- **Approach**: `position: fixed` nav + `.nav-spacer` div in document flow. Nav is completely out of flow — inner height changes can never shift scrollY.
- **Spacer**: JS sets `spacer.style.height = nav.offsetHeight + 'px'` on load, resize, AND logo image load (critical — logo is ~150px and loads async, so nav height isn't correct until then)
- **Scrolled state**: `.nav-scrolled .nav-brand { padding: 0.25rem 0 0 }`, logo 90×90px, `.nav-links` padding-bottom 0.5rem + gap 1.5rem
- **CSS transitions**: 0.3s ease on padding, max-width/max-height, gap — smooth visual shrink
- **JS**: simple class toggle at shrink@80px / expand@25px — no min-height pinning, no overflow manipulation
- **Resize**: resets scrolled state, re-syncs spacer height
- **Mobile (≤768px)**: bypassed entirely — no shrink
- **homepage-v2**: has fixed nav + spacer but NO shrink logic (plain nav)

## Known Gotchas
- **Duplicate CSS selector bug**: When adding new CSS properties to `.nav-brand` across multiple HTML files via replace_in_file, the SEARCH block must include the full opening `{` context to avoid creating a duplicate unclosed brace. Always verify the replacement doesn't produce `selector {\nselector {` — this silently breaks all CSS that follows.
</coder>
