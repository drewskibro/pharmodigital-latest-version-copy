# Debugging Records & Issue Tracking

*This file is the single source of truth for debugging sessions, issues, and troubleshooting history in this project.*

## Purpose

Records debugging sessions, error patterns, root causes, solutions, and recurring issues. This file enables systematic problem-solving, prevents re-solving the same bugs, and provides context for future debugging efforts. It supports Roo Code's Debug Mode by maintaining a persistent record of diagnostic work.

## When to Update This File

Update this file when:
- Encountering a new error, bug, or unexpected behavior
- Identifying a root cause during investigation
- Applying a fix or workaround (successful or not)
- Noticing a recurring issue pattern
- During systematic debugging sessions (e.g., in Debug Mode)
- Discovering performance issues, edge cases, or race conditions
- After verifying a fix works across relevant scenarios

**Do not** log transient one-liners or obvious typos. Focus on issues requiring investigation or likely to recur.

## Format

Each entry follows this structure:

```
### [YYYY-MM-DD HH:MM] — [Short Issue Title]

**Status:** Open | Investigating | Fixed | Recurring | Won't Fix
**Symptoms:** What went wrong. Error messages, stack traces, reproduction steps.
**Environment:** dependencies, affected files.
**Root Cause:** (if found) What caused it.
**Investigation Steps:**
- Step 1: What was tried, results.
- Step 2: etc.
**Solution:** What fixed it (code changes, config, workaround).
**Prevention:** How to avoid this in future (patterns, tests, docs).
**Related:** Links to DECISIONS.md entries, commits, or tickets.
```

Mark as **Recurring** if the issue returns.

If this file gets corrupted, re-create it. 
CRITICAL: Keep this file under 300 lines. You are allowed to summarize, change the format, delete entries, etc., in order to keep it under the limit.

---

## Current Issues

### [2026-04-21] — Mobile menu not opening on index.html — RESOLVED

**Status:** Fixed (Step 3 of 4)
**Symptoms:** Tapping hamburger on mobile does nothing. Overlay never appears.
**Environment:** index.html, all mobile viewports (≤768px)
**Root Cause (ACTUAL):** Missing `</div>` closing tag for `.nav-mobile-overlay` — entire page content (hero, sections, footer) was inside the overlay div. When overlay was hidden, entire page disappeared.
**Secondary issue:** `display:none` base + `display:flex` on `.mobile-open` can't be CSS-transitioned — overlay appeared without animation.
**Investigation Steps:**
- Step 1: Added `__ANIMA_DBG__` logs — confirmed handler fires but overlay not visible
- Step 2: Moved overlay outside sticky nav, added touchend for iOS, z-index→9999
- Step 3: Found missing `</div>` — the ACTUAL root cause. Reverted to `display:flex` always with `visibility/opacity/pointer-events` for show/hide
**Solution:** Added missing `</div>`, reverted to visibility-based show/hide, cleaned up JS to single click handler with `isOpen` flag, accordion panels reset on close. Fixed smooth scroll handler throwing SyntaxError on `querySelector("#")` for bare-hash overlay links.
**Prevention:** Never place `position:fixed` overlays inside `position:sticky` containers. Always verify closing tags for overlay containers. Guard `querySelector()` calls against bare `#` selectors.

### [2026-04-22] — Nav scroll flicker — 4-step fix plan in progress

**Status:** Fixed (all 4 steps complete)
**Symptoms:** Non-stop flickering when scrolling up/down on desktop. Nav bar rapidly toggles between expanded/collapsed states.
**Root Cause:** `.nav-scrolled` class changed layout properties (`min-height`, `padding`, `max-width/height` on logo) → content shifted → `scrollY` changed → class toggled back → infinite reflow loop. Hysteresis alone (shrink@100px/expand@30px) insufficient because layout shift (~120px) jumped past the dead zone.
**Solution (in progress — 4 steps):**
1. ✅ Replace layout-affecting CSS with `transform: scale(0.55)` on `.nav-inner` — GPU-composited, no reflow
2. ✅ Pin nav bar height (`--nav-pinned-height`) and use inner transforms (`scale(0.65) translateY(-12%)`) for shrink effect
3. ✅ Debounce scroll expand-back (50ms) + `will-change: transform, filter` on `.nav-brand img`
4. ✅ Remove negative `margin-top: -45px` on hero → `margin-top: 0` to stabilize content flow
**Current status:** All 4 steps complete — nav flicker fix fully deployed

### [2026-04-23] — Nav flicker audit: Step 1 complete (all 6 pages read)

**Status:** Investigating — Step 1 of 5 complete
**Symptoms:** Nav flicker persists despite multiple fix attempts. Dropdowns break when overflow:hidden is used; flicker returns when it's removed.
**Audit findings:**
- **5 pages** have shrink-on-scroll: index, web-pro-elite, ai-domination-system, case-study-ealing, salesagent
- **1 page** has NO shrink logic: homepage-v2 (plain sticky nav, no `.nav-scrolled`)
- **Current approach**: `position: sticky` + JS `min-height` pin + class toggle at 80px/25px hysteresis — NO overflow set
- **Root cause**: `min-height` on a `sticky` nav doesn't truly decouple from document flow; when `.nav-scrolled` shrinks inner elements (logo 150→90px, padding changes), the sticky positioning context still allows reflow near the threshold
- **Approved fix (Step 2)**: Replace `sticky` + `min-height` with `position: fixed` + spacer div. Nav fully removed from flow. Inner height changes never affect scrollY. Dropdowns work naturally since nothing is clipped.

### [2026-04-23] — Dropdown menus invisible after flicker fix — RESOLVED

**Status:** Fixed
**Symptoms:** Hovering "Who We Help" / "Our Work" / "The Proof" shows nothing — dropdown menus don't appear on any page.
**Root Cause:** The flicker fix added `nav.style.overflow = 'hidden'` to pin the nav height. This clipped `.nav-dropdown-menu` elements which render below the nav boundary via `position: absolute; top: 100%`.
**Solution:** Removed `overflow: hidden` from the JS pin logic. The `min-height` pin alone prevents layout shift (and thus flicker) without clipping child content. Also removed the corresponding `overflow: ''` reset on resize.
**Prevention:** Never apply `overflow: hidden` to a container that has absolutely-positioned children (dropdowns, tooltips) that render outside its bounds. Use `min-height` pinning alone for layout-shift prevention.

<!-- Newest debugging entries first. Closed issues move to "Resolved Issues" below. -->

## Resolved Issues

<!-- Historical debugging records -->
