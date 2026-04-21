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

## Nav Structure Reference (all 6 pages)
- **Nav layout**: `.nav-inner` uses `grid-template-columns: 1fr auto 1fr` — three-column centred logo
- **Nav classes**: `.nav` (sticky), `.nav-inner` (grid, 110px/96px/80px height), `.nav-brand` (centred logo, grid-column:2), `.nav-links` (left links, grid-column:1), `.nav-links-right` (right links + CTA, grid-column:3), `.nav-hamburger` (mobile ≤768px), `.nav-mobile-overlay` (mobile menu)
- **Logo img**: `uploaded-asset-1776767932323-0.png` at 100×100 max (desktop), 80px tablet, 64px mobile
- **Logo effects**: `drop-shadow(0 2px 8px rgba(201,164,74,0.25))` + hover glow/scale
- **Dropdown**: `.nav-dropdown` with `.nav-dropdown-trigger` + `.nav-dropdown-menu`
- **Mobile**: hamburger toggles `.mobile-open` class on `.nav-mobile-overlay`; nav-inner falls back to `display:flex`
- **Breakpoints**: 1024px (tablet logo 80px, nav 96px), 768px (mobile logo 64px, nav 80px, .nav-links + .nav-links-right hidden)
- **homepage-v2 quirk**: still uses "PharmoBoost" label instead of "Services"

## Known Gotchas
- **Duplicate CSS selector bug**: When adding new CSS properties to `.nav-brand` across multiple HTML files via replace_in_file, the SEARCH block must include the full opening `{` context to avoid creating a duplicate unclosed brace. Always verify the replacement doesn't produce `selector {\nselector {` — this silently breaks all CSS that follows.
</coder>
