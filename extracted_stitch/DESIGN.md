# Design System Specification: The Architectural Sovereign

## 1. Overview & Creative North Star
The North Star for this design system is **"The Digital Vault."** 

In the Moroccan Fintech landscape, trust is not merely a feature—it is the foundation of every interaction. This system moves away from the "generic SaaS" look by adopting a High-End Editorial aesthetic. We achieve this through a philosophy of **Tonal Architecture**: using depth, sophisticated layering, and expansive negative space to create an environment that feels both ultra-secure and effortless.

Instead of a rigid, boxed-in grid, we utilize intentional asymmetry and "breathable" layouts. We treat the interface like a premium financial atelier—organized, authoritative, and bespoke. By leveraging large radii and soft tonal transitions, we bridge the gap between "cold high-tech" and "local warmth."

---

## 2. Colors & Surface Philosophy

### The "No-Line" Rule
To achieve a high-end, seamless feel, **1px solid borders are strictly prohibited for sectioning.** Boundaries must be defined through background color shifts or tonal transitions. Use `surface-container-low` sections sitting on a `surface` background to create natural division.

### Surface Hierarchy & Nesting
Treat the UI as a series of physical layers, like stacked sheets of frosted glass.
- **Base Layer:** `surface` (#faf8ff)
- **Secondary Sectioning:** `surface-container-low` (#f2f3ff)
- **Interactive Components:** `surface-container-lowest` (#ffffff) for high-contrast cards.
- **Elevated Modals:** `surface-container-highest` (#dae2fd) to draw focus.

### The Glass & Gradient Rule
To move beyond "flat" design, primary CTAs and Hero backgrounds should use **Signature Textures**. 
- **The Sovereign Gradient:** A subtle transition from `primary` (#000000 / Deep Navy base) to `primary-container` (#131b2e) adds a three-dimensional "soul" to the interface.
- **Glassmorphism:** For floating navigation or overlays, use semi-transparent `surface` colors with a 20px-30px backdrop-blur to soften the environment.

---

## 3. Typography: The Editorial Voice

We utilize a high-contrast typographic scale to establish authority.

*   **Headers: Plus Jakarta Sans.** A modern geometric sans-serif that feels "high-tech" yet approachable. Use `display-lg` (3.5rem) with tight letter-spacing for hero sections to create a bold, editorial impact.
*   **Body: Inter.** Chosen for its maximum legibility in complex financial data.
*   **The Hierarchy Strategy:** 
    *   **Headlines:** Use `headline-lg` (2rem) in `on_background` (#131b2e) for clear section entry points.
    *   **Data Points:** Use `title-lg` (1.375rem) for monetary values, ensuring they feel substantial and trustworthy.
    *   **Captions:** Use `label-sm` (0.6875rem) with increased letter-spacing in `on_surface_variant` (#45464d) for a premium, refined feel.

---

## 4. Elevation & Depth

### The Layering Principle
Depth is achieved by "stacking" surface tiers. Place a `surface-container-lowest` card on a `surface-container-low` background. This creates a "soft lift" that feels architectural rather than digital.

### Ambient Shadows
When a floating effect is required (e.g., a primary action menu):
- **Blur:** 40px to 60px.
- **Opacity:** 4% - 8%.
- **Color:** Use a tinted version of `on_surface` (#131b2e) rather than pure black to mimic natural light within the "Deep Navy" environment.

### The "Ghost Border" Fallback
If accessibility requires a border, use a **Ghost Border**: `outline-variant` (#c6c6cd) at 15% opacity. Never use 100% opaque borders.

---

## 5. Components

### Buttons & Interaction
- **Primary Sovereign:** Uses the `tertiary_container` (#cba72f) Soft Gold. It should feel like a minted coin—premium and singular. 
- **Secondary Growth:** Uses `secondary` (#006c4a) with `on_secondary` (#ffffff) text.
- **Radius:** All buttons must use `rounded-full` (9999px) or `xl` (3rem) to maintain the "Modern Minimalist" softness.

### Cards & Lists
- **Rule:** Forbid divider lines. 
- **Separation:** Use 24px - 32px of vertical white space or a subtle shift to `surface-container-low`.
- **Corner Radius:** Cards must strictly follow the `xl` (3rem) or `lg` (2rem) tokens for a friendly, high-tech silhouette.

### Input Fields
- **Background:** `surface_container_low`.
- **Focus State:** Transition to a `secondary` (#006c4a) "Ghost Border" and a subtle glow.
- **Shape:** `rounded-md` (1.5rem) to balance the extreme curves of buttons.

### Specialized Fintech Components
- **The "Trust Badge":** A small, Glassmorphic chip using `secondary_container` with `on_secondary_container` text to highlight "Verified" or "Secure" statuses.
- **Balance Cards:** Use a subtle `primary_container` gradient with `on_primary_container` text for a dark, prestigious "Black Card" aesthetic.

---

## 6. Do's and Don'ts

### Do
*   **Do** use extreme white space. If you think there is enough space, add 16px more.
*   **Do** use `rounded-3xl` for main dashboard containers to evoke a sophisticated, modern mobile-app feel even on desktop.
*   **Do** use Emerald Green (`secondary`) specifically for growth metrics and "Success" states to resonate with local Moroccan symbolism.

### Don't
*   **Don't** use pure black (#000000) for text; use `on_background` (#131b2e) to maintain the Navy depth.
*   **Don't** use sharp 90-degree corners. Everything must feel "honed" and "smoothed."
*   **Don't** use high-contrast dividers. Let the background colors do the work.
*   **Don't** use standard shadows. If the shadow looks like a shadow, it’s too dark. It should look like a "glow of depth."