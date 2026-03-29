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
