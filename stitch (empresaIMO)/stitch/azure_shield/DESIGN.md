# Design System Specification: The Architectural FinTech Standard

## 1. Overview & Creative North Star
**Creative North Star: "The Digital Bastion"**

To move beyond the generic "SaaS-blue" template, this design system adopts a philosophy of **Architectural Editorial**. In the world of Insurtech and high-level Fintech (IMOs), trust is not built with flashy animations, but through structural integrity and spatial intentionality. 

We break the "template" look by treating the screen as a series of physical, layered planes. We utilize **intentional asymmetry**—where heavy, authoritative typography is balanced by expansive, breathable white space. This system rejects the "boxed-in" grid in favor of a fluid, open-plan layout that feels both technologically advanced and human-centric. It is a digital environment that feels curated, not just programmed.

---

## 2. Colors & Surface Philosophy

Our palette is anchored in deep, "Midnight" navies and "Slate" grays, providing a foundation of absolute stability, punctuated by a "Vibrant Success" green that acts as a beacon for action.

### The "No-Line" Rule
**Traditional 1px borders are strictly prohibited for sectioning.** To achieve a high-end, premium feel, boundaries must be defined solely through background color shifts. For example, a `surface_container_low` section should sit directly on a `surface` background. The eye should perceive change through tonal depth, not structural "caging."

### Surface Hierarchy & Nesting
Treat the UI as a series of stacked sheets of fine paper or frosted glass. Use the following hierarchy to define importance:
*   **Base Layer:** `surface` (#faf8ff) - The canvas.
*   **Secondary Context:** `surface_container_low` (#f2f3ff) - Subtle grouping.
*   **Interactive/Elevated:** `surface_container_highest` (#dae2fd) - To draw the eye.

### The "Glass & Gradient" Rule
To inject "soul" into the tech, use **Glassmorphism** for floating elements (drawers, navigation bars, or modals).
*   **Formula:** `surface` color at 70% opacity + `backdrop-blur: 20px`.
*   **Signature Gradients:** For primary CTAs and Hero sections, use a subtle linear gradient: `primary` (#00113a) to `primary_container` (#002366). This prevents the UI from feeling "flat" or "cheap."

---

## 3. Typography: The Editorial Voice

We utilize a dual-typeface system to balance technical precision with approachable authority.

*   **Display & Headline (Manrope):** Our "voice." Manrope’s geometric yet warm curves provide an innovative, modern edge. Use `display-lg` (3.5rem) with tight letter-spacing (-0.02em) for hero moments to create an editorial, high-trust impact.
*   **Body & UI (Inter):** Our "engine." Inter is chosen for its world-class legibility in complex data environments. It ensures that LatAm and US users alike can digest financial data without cognitive load.

**Hierarchy Note:** Always maintain a high contrast between `headline-lg` and `body-md`. This "Scale Leap" is what separates premium editorial design from standard UI.

---

## 4. Elevation & Depth: Tonal Layering

We convey resilience not through heavy shadows, but through **Tonal Layering**.

*   **The Layering Principle:** Instead of a shadow, place a `surface_container_lowest` (#ffffff) card on a `surface_container_low` (#f2f3ff) background. This creates a "soft lift" that feels architectural.
*   **Ambient Shadows:** If an element must float (e.g., a dropdown), use a shadow that mimics natural light: `color: on_surface` at 6% opacity, `blur: 40px`, `y: 20px`. Never use pure black shadows.
*   **The "Ghost Border" Fallback:** If accessibility requirements demand a border (e.g., input fields), use a "Ghost Border": `outline_variant` (#c5c6d2) at **20% opacity**. It should be felt, not seen.

---

## 5. Components

### Buttons: The Kinetic Anchor
*   **Primary:** Gradient fill (`primary` to `primary_container`), `on_primary` text, `lg` (0.5rem) roundedness.
*   **Secondary:** `surface_container_high` background with `on_secondary_container` text. No border.
*   **Tertiary:** Ghost style. No background, `primary` text, bold weight.

### Input Fields: Clean Trust
*   **Style:** `surface_container_lowest` background. 
*   **State:** On focus, transition to a `px` Ghost Border using `primary`. 
*   **Labels:** Use `label-md` (Inter, 0.75rem) in `on_surface_variant`. Always visible, never floating placeholders.

### Cards & Lists: The No-Divider Rule
*   **Execution:** Forbid 1px horizontal dividers. To separate list items, use `8` (2rem) vertical spacing or alternate backgrounds between `surface` and `surface_container_low`. 
*   **Cards:** Use `xl` (0.75rem) roundedness for large containers to soften the "industrial" feel of the tech.

### Specialized Component: The "Trust Shield" Data Badge
*   **Usage:** For displaying policy status or financial health.
*   **Style:** A `tertiary_container` background with `on_tertiary_container` (vibrant green) text. High contrast, pill-shaped (`full` roundedness), using `label-sm` for an "official" look.

---

## 6. Do’s and Don’ts

### Do:
*   **Do** use asymmetrical padding. Give titles more "top-room" than "bottom-room" to create a sense of gravity.
*   **Do** utilize `tertiary` (success green) sparingly. It is a laser, not a paint brush. Use it only for final conversion points and "positive" data states.
*   **Do** test all contrast ratios. Ensure `on_surface` text on `surface_container` tiers meets WCAG 2.1 AA standards for our diverse user base.

### Don’t:
*   **Don’t** use "Default" shadows. They look "off-the-shelf" and diminish the brand’s innovative personality.
*   **Don’t** use 100% opaque borders to separate content. It creates "visual noise" that suggests a lack of confidence in the layout’s spatial logic.
*   **Don’t** overcrowd data. In Fintech, "Professionalism" equals "Clarity." If a screen feels full, use a `24` (6rem) spacer to force a break.