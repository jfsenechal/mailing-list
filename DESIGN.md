---
name: Carnets et liste de diffusion
description: A calm, instrument-like Filament admin for managing contacts and sending mailing-list campaigns with confidence.
colors:
  primary: "oklch(0.623 0.214 259.815)"
  primary-strong: "oklch(0.546 0.245 262.881)"
  success: "oklch(0.723 0.219 149.579)"
  warning: "oklch(0.769 0.188 70.08)"
  danger: "oklch(0.637 0.237 25.331)"
  info: "oklch(0.685 0.169 237.323)"
  surface: "oklch(0.994 0.0015 264)"
  surface-sunken: "oklch(0.985 0.0015 264)"
  border: "oklch(0.92 0.002 286)"
  text: "oklch(0.21 0.006 285.885)"
  text-muted: "oklch(0.552 0.016 285.938)"
  dark-surface: "oklch(0.21 0.006 285.885)"
  dark-border: "oklch(0.274 0.006 286.033)"
typography:
  display:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.875rem"
    fontWeight: 700
    lineHeight: 1.2
    letterSpacing: "-0.01em"
  headline:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.25rem"
    fontWeight: 600
    lineHeight: 1.3
  title:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1rem"
    fontWeight: 600
    lineHeight: 1.4
  body:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.875rem"
    fontWeight: 400
    lineHeight: 1.5
  label:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.75rem"
    fontWeight: 500
    lineHeight: 1.4
    letterSpacing: "0.01em"
rounded:
  sm: "6px"
  md: "8px"
  lg: "12px"
  full: "9999px"
spacing:
  xs: "4px"
  sm: "8px"
  md: "16px"
  lg: "24px"
  xl: "32px"
components:
  button-primary:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.surface}"
    rounded: "{rounded.md}"
    padding: "8px 14px"
  button-primary-hover:
    backgroundColor: "{colors.primary-strong}"
    textColor: "{colors.surface}"
  button-send:
    backgroundColor: "{colors.success}"
    textColor: "{colors.surface}"
    rounded: "{rounded.md}"
    padding: "8px 14px"
  badge-sent:
    backgroundColor: "{colors.success}"
    textColor: "{colors.surface}"
    rounded: "{rounded.sm}"
    padding: "2px 8px"
  input:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.text}"
    rounded: "{rounded.md}"
    padding: "8px 12px"
---

# Design System: Carnets et liste de diffusion

## 1. Overview

**Creative North Star: "The Control Room"**

This is an instrument panel, not a marketing surface. Every screen exists so a
member of a small association can maintain address books and contacts, compose a
newsletter, see exactly who it will reach, and dispatch it once, with full
confidence. The visual language is calm and legible: a quiet neutral field where
status is always readable at a glance and color appears only where it carries
meaning. Blue is the resting "system nominal" tone; the state colors (green, amber,
red) light up only to report what is happening to a campaign.

The system is built on Filament v5 (Livewire, Alpine, Tailwind v4) and embraces
Filament's restrained component vocabulary rather than fighting it. Surfaces are
flat and layered tonally; type is a single humanist sans at modest sizes; spacing
is generous enough to keep dense admin data breathable. Nothing is decorative. The
one dramatic moment in the whole product, the irreversible send, is deliberately
gated behind a confirmation that states the recipient count before it commits.

This system explicitly rejects three things named in PRODUCT.md: the **generic SaaS
dashboard** (hero-metric cards, gradient accents, identical icon grids), the **loud
consumer marketing email tool** (busy, colorful, mascot-driven), and the **cold
enterprise back-office** (sterile all-gray density that punishes non-technical
users). It sits between them: warm-neutral, quiet, and trustworthy.

**Key Characteristics:**
- Calm neutral baseline; color reserved for state and the primary action.
- Flat surfaces, depth from tonal layering and hairline borders, not shadows.
- A single humanist sans (Instrument Sans) across the whole hierarchy.
- State is never color-only: badge color is always paired with a French label.
- The send path shows its consequence (recipient count) before it commits.

## 2. Colors

A near-neutral zinc field carrying one calm blue primary, with three semantic
state colors that appear only on campaign status and consequential actions.

### Primary
- **Signal Blue** (oklch(0.623 0.214 259.815), Tailwind blue-500): The resting
  "system nominal" accent. Used for the primary action button, active navigation,
  links, focus rings, and the `Draft` status badge. It reads as steady, not urgent.
- **Deep Signal Blue** (oklch(0.546 0.245 262.881), blue-600): Hover and pressed
  state for primary controls; the committed, slightly darker version of the accent.

### Secondary (semantic state colors)
- **Dispatch Green** (oklch(0.723 0.219 149.579)): Success. The `Sent` status and
  the "Envoyer" send action. Green means a campaign reached its recipients.
- **In-Flight Amber** (oklch(0.769 0.188 70.08)): Warning. The `Sending` status and
  the "Apercu" (preview) action, an in-between, attention-worthy moment.
- **Failure Red** (oklch(0.637 0.237 25.331)): Danger. The `Failed` status and all
  destructive actions (delete). Used sparingly and never decoratively.
- **Info Sky** (oklch(0.685 0.169 237.323)): Informational affordances (help and
  documentation links). A lighter, cooler blue distinct from the primary.

### Neutral
- **Ink** (oklch(0.21 0.006 285.885), ~zinc-900): Primary text and the dark-mode
  surface. Tinted faintly toward the brand hue, never pure black.
- **Muted Ink** (oklch(0.552 0.016 285.938), ~zinc-500): Secondary text, captions,
  placeholder, disabled labels.
- **Hairline** (oklch(0.92 0.002 286), ~#e4e4e5): Borders and dividers, including
  the sidebar's right edge. In dark mode this becomes oklch(0.274 0.006 286).
- **Surface** (oklch(0.994 0.0015 264)): Cards, sections, inputs. A near-white
  faintly tinted toward the brand hue, never pure white.
- **Sunken Surface** (oklch(0.985 0.0015 264)): The page background beneath cards;
  the lower tonal layer that gives flat surfaces their depth.

### Named Rules
**The Meaning-Only Color Rule.** Color is forbidden as decoration. Every saturated
color on screen must report a state (badge), mark the one primary action, or flag a
destructive action. If a color is not carrying meaning, it must be neutral.

**The Signal-Blue-At-Rest Rule.** Blue is the calm baseline, not an alarm. Urgency
is expressed by amber and red on state, never by flooding the screen with primary.

## 3. Typography

**Display / Body Font:** Instrument Sans (with ui-sans-serif, system-ui fallback)

**Character:** A single humanist sans across the entire hierarchy. Friendly and
contemporary without being playful, it keeps the tool approachable for
non-technical users while staying crisp in dense tables. Hierarchy comes from scale
and weight, not from a second typeface.

### Hierarchy
- **Display** (700, 1.875rem, line-height 1.2): Page titles (resource list headings,
  "Emails", "Contacts"). The largest type on any screen.
- **Headline** (600, 1.25rem, line-height 1.3): Section and modal headings, form
  section titles ("Envoyer la newsletter").
- **Title** (600, 1rem, line-height 1.4): Card titles, table-row emphasis, field
  group labels.
- **Body** (400, 0.875rem, line-height 1.5): The workhorse size for table cells,
  field values, descriptions, and modal copy. Cap reading measure at 65-75ch.
- **Label** (500, 0.75rem, +0.01em): Form field labels, badge text, table column
  headers, helper text.

### Named Rules
**The One-Voice Type Rule.** One family does all the work. Never introduce a second
display or serif face to create emphasis; raise the weight or the size instead.

## 4. Elevation

Flat by default, with depth conveyed through tonal layering rather than shadows.
Cards and sections sit as flat surfaces (Surface) on a slightly darker page
(Sunken Surface), separated by hairline borders. Shadows are reserved exclusively
for genuinely floating elements that need to detach from the plane: dropdown menus,
popovers, and modal dialogs. A resting card never casts a shadow.

### Shadow Vocabulary
- **Floating** (`box-shadow: 0 4px 16px oklch(0.21 0.006 286 / 0.10)`): Dropdowns,
  popovers, command palette. A soft ambient lift that says "temporary, on top".
- **Modal** (`box-shadow: 0 16px 48px oklch(0.21 0.006 286 / 0.18)`): Confirmation
  and form dialogs, including the send confirmation. Pairs with a backdrop scrim.

### Named Rules
**The Flat-At-Rest Rule.** Surfaces are flat at rest. A shadow is a response to a
floating state (open menu, open modal), never a default decoration on a card. If a
card has a drop shadow while sitting still, the shadow is wrong.

## 5. Components

Components follow Filament v5 defaults, tuned to feel refined and restrained:
quiet by default, modest radius, color only where it means something.

### Buttons
- **Shape:** Gently rounded (8px, `{rounded.md}`).
- **Primary:** Signal Blue fill, Surface text, 8px/14px padding. One per screen,
  marking the single most important action.
- **Send ("Envoyer"):** Dispatch Green fill with a paper-airplane icon. The
  consequential green action; disabled when recipient count is zero.
- **Preview ("Apercu"):** In-Flight Amber, eye icon. A safe rehearsal of the send.
- **Destructive:** Failure Red, trash icon, always behind confirmation.
- **Hover / Focus:** Darken to the -strong tone on hover; a 2px Signal Blue
  focus-visible ring on keyboard focus. Transitions on color only, ~150ms ease-out.
- **Secondary / Ghost:** Neutral text on transparent or Hairline-bordered fill for
  non-primary actions, so the colored action always wins the eye.

### Badges (signature)
- **Style:** Small pill (6px radius, `{rounded.sm}`), tinted fill with matching
  text, paired with an icon. Used for `EmailStatus`.
- **State mapping:** `Brouillon` (Draft) -> Signal Blue; `Envoi en cours` (Sending)
  -> In-Flight Amber; `Envoyé` (Sent) -> Dispatch Green; `Echec de l'envoi`
  (Failed) -> Failure Red. The label always accompanies the color.

### Cards / Containers (Filament sections)
- **Corner Style:** 12px (`{rounded.lg}`).
- **Background:** Surface, on a Sunken Surface page.
- **Shadow Strategy:** None at rest (see Elevation).
- **Border:** 1px Hairline.
- **Internal Padding:** 24px (`{spacing.lg}`).

### Inputs / Fields
- **Style:** Surface fill, 1px Hairline border, 8px radius, 8px/12px padding.
- **Focus:** Border shifts to Signal Blue with a soft Signal Blue ring; no glow.
- **Error:** Failure Red border plus a Failure Red message below; never color-only.
- **Disabled:** Muted Ink text on Sunken Surface, reduced contrast.

### Navigation
- **Style:** Collapsible left sidebar (collapsible on desktop), separated from
  content by a 1px Hairline right border. SPA navigation, no full reloads.
- **States:** Default Muted Ink label; hover lifts to Ink; active item carries a
  Signal Blue label and icon. Global search with a Ctrl/Cmd+K affordance.
- **Mobile:** Sidebar collapses to an overlay drawer.

### Send Confirmation (signature pattern)
The product's defining interaction. The "Envoyer" action opens a Modal-elevation
dialog headed "Envoyer la newsletter" whose description states the exact recipient
count ("Cet e-mail sera envoyé à N destinataires. Continuer ?") before anything is
sent. The action is disabled when there are zero recipients or attachments exceed
the size limit. This is the visual embodiment of "show the consequence before the
commit".

## 6. Do's and Don'ts

### Do:
- **Do** keep color meaningful: reserve saturated color for status badges, the one
  primary action, and destructive actions (the Meaning-Only Color Rule).
- **Do** pair every status color with its French label and icon; never communicate
  state by color alone (WCAG 2.2 AA, color-blind safety).
- **Do** gate every irreversible action behind a confirmation that states its
  consequence (recipient count, list, what will happen) before it commits.
- **Do** keep surfaces flat at rest; reach for shadow only on floating menus and
  modals.
- **Do** tint neutrals faintly toward the blue hue and use Ink/Surface instead of
  pure black or pure white.
- **Do** maintain a visible 2px Signal Blue focus ring on all interactive elements
  and respect `prefers-reduced-motion`.

### Don't:
- **Don't** build a **generic SaaS dashboard**: no hero-metric template (big number
  + small label + gradient accent), no identical icon-heading-text card grids, no
  gradients standing in for hierarchy.
- **Don't** drift toward a **loud consumer marketing email tool** (Mailchimp-style):
  no busy multi-color screens, mascots, or personality that competes with clarity.
- **Don't** become a **cold enterprise back-office**: no sterile all-gray density
  that intimidates non-technical users.
- **Don't** use `border-left`/`border-right` greater than 1px as a colored accent
  stripe on cards, list items, or alerts. Use full hairline borders or tinted fills.
- **Don't** use gradient text (`background-clip: text`) or glassmorphism anywhere.
- **Don't** use pure `#000` or `#fff`; use Ink and Surface.
- **Don't** flood a screen with primary blue to signal urgency; that is amber's and
  red's job, on state only.
- **Don't** use em dashes in UI copy; the French labels stay plain and direct.
