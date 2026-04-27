# Debugging Log

## [2026-04-27] Nav Dropdown Blocking Adjacent Links

### Symptom
"The Proof" dropdown's hover area prevents clicking "About" link — user must click outside first.

### Root Cause (3 overlapping issues)

1. **`::before` bridge extends 16px beyond each side of the dropdown menu**
   ```css
   .nav-dropdown-menu::before {
     left: -16px;
     right: -16px;
   }
   ```
   The "The Proof" dropdown menu (440px wide, centred on its trigger) produces a bridge that is 472px wide. This overlaps "About".

2. **Bridge has `pointer-events: auto`** — so the cursor enters the bridge (which is INSIDE `.nav-dropdown`) before reaching "About". Since the JS removes `.dd-force-closed` on `mouseenter` of any `.nav-dropdown`, the bridge **re-opens the dropdown** before the cursor can touch "About".

3. **Cursor path**: User mouses from "The Proof" trigger → moves right toward "About" → cursor passes through the invisible `::before` bridge → JS fires `mouseenter` on `.nav-dropdown` → `dd-force-closed` is removed → dropdown re-appears → "About" is obscured by the dropdown panel.

### Fix Plan (Steps 2–4)

**Step 2 — CSS: Clip the bridge's horizontal extent** ✅ DONE
- Changed `left: -16px; right: -16px` → `left: 0; right: 0` on `.nav-dropdown-menu::before`
- Added `z-index: 200` to `.nav-links a, .nav-links-right a` so plain links sit above dropdown panels (`z-index: 100`)
- Applied to: index.html, about.html (remaining 6 pages in Step 4)

**Step 3 — JS: Add z-index stacking so plain links always sit above dropdown menus on hover**
- Harden: when any `dd-force-closed` is applied, also set a short `pointer-events: none` timeout on the dropdown menus 
- Or: restructure so the bridge's `pointer-events: auto` doesn't propagate to the parent `.nav-dropdown`'s `mouseenter`

**Step 4 — Propagate to all 8 pages**

### Files affected
All 8 HTML pages with the shared nav:
- index.html, about.html, salesagent.html, web-pro-elite.html
- ai-domination-system.html, case-study-ealing.html, homepage-v2.html, case-study-southdowns.html
