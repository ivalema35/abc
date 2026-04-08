# ABC Project — Figma Auto-Layout Specification Document
## Animal Birth Control Management System · Goal Foundation
### Version 1.0 · Android UI · Sneat Bootstrap 5 Theme Adaptation

> **Prepared for:** Figma UI/UX Designer
> **Frame Size:** 390 × 844px (Industry-standard prototype frame · export specs at 360 × 800px for Android)
> **Theme:** Sneat Bootstrap 5 Admin PRO · Public Sans font
> **Icon Library:** Material Symbols (Rounded) · via Figma plugin
> **Status:** AUTHORITATIVE HANDOFF — Do not begin screens before completing Section 1

---

---

# SECTION 1 — Figma Variables & Styles Setup (The Foundation)

> **CRITICAL:** Set up ALL variables, text styles, and effects in this section BEFORE touching any screens. Every component and screen references these tokens by name. Changing a token here automatically updates all components.

---

## 1.1 Color Variables

**How to create in Figma:**
`Left Panel → Local Variables → + Create Variable → Color`
Name each variable using the exact path shown (e.g., `Primary/Main`). Figma will group them into folders.

### Primary Group

| Variable Name | Hex Value | Usage |
|---|---|---|
| `Primary/Main` | `#696cff` | Buttons, FAB, Active tabs, Links, Focused inputs |
| `Primary/Light` | `#e7e7ff` | Icon container backgrounds, chip backgrounds |
| `Primary/Dark` | `#5558e3` | Pressed / ripple state on primary buttons |
| `Primary/On` | `#ffffff` | Text & icons rendered ON a primary-colored surface |

### Neutral Group

| Variable Name | Hex Value | Usage |
|---|---|---|
| `Neutral/Background` | `#f5f5f9` | App-wide background (behind all cards) |
| `Neutral/Surface` | `#ffffff` | Cards, Bottom Sheet, Bottom Nav, TopAppBar |
| `Neutral/Divider` | `#dbdade` | Horizontal list dividers, dashed upload borders |
| `Neutral/Border` | `#e7e7e8` | Default text input borders |
| `Neutral/Disabled` | `#b9b9b9` | Disabled button backgrounds, disabled input text |

### Text Group

| Variable Name | Hex Value | Usage |
|---|---|---|
| `Text/Heading` | `#333333` | Display, Headline — H1/H2/H3 |
| `Text/Primary` | `#566a7f` | Body text, Title styles |
| `Text/Secondary` | `#8592a3` | Subtitles, hints, placeholders, captions |
| `Text/OnSurface` | `#697a8d` | Input labels (Label-Large), supporting text |
| `Text/OnPrimary` | `#ffffff` | Text on primary-colored backgrounds |

### Status Group

| Variable Name | Hex Value | Usage |
|---|---|---|
| `Status/Success` | `#28c76f` | Active badge text, success icons |
| `Status/SuccessLight` | `#e8f8ee` | Active badge background |
| `Status/Danger` | `#ea5455` | Delete actions, error states, Inactive badge text |
| `Status/DangerLight` | `#fce8e8` | Inactive badge background, error input background |
| `Status/Warning` | `#ff9f43` | Warning states, pending states |
| `Status/WarningLight` | `#fff3e5` | Warning chip background |
| `Status/Info` | `#00cfe8` | Informational states |
| `Status/InfoLight` | `#e0f9fc` | Info chip background |

### Login Screen Gradient

| Variable Name | Hex Value | Usage |
|---|---|---|
| `Gradient/LoginTop` | `#f5f5f9` | Login screen background gradient — top |
| `Gradient/LoginBottom` | `#eeeeff` | Login screen background gradient — bottom |

### Hero Card Gradient

| Variable Name | Hex Value | Usage |
|---|---|---|
| `Gradient/HeroStart` | `#696cff` | Dashboard welcome card gradient — left |
| `Gradient/HeroEnd` | `#9c9eff` | Dashboard welcome card gradient — right |

---

## 1.2 Typography Styles

**How to create in Figma:**
`Left Panel → Text Styles → + → set Font, Weight, Size, Line Height → name exactly as shown below.`

**Import font first:** Use the Google Fonts plugin in Figma → search "Public Sans" → import all weights (400, 500, 600, 700).

| Style Name | Font Family | Size (px) | Weight | Line Height | Color Variable | Usage |
|---|---|---|---|---|---|---|
| `Display/Large` | Public Sans | 24 | 700 (Bold) | 32px | `Text/Heading` | Stat card values, screen hero numbers |
| `Display/Medium` | Public Sans | 20 | 600 (SemiBold) | 28px | `Text/Heading` | Section titles |
| `Headline/Large` | Public Sans | 18 | 600 (SemiBold) | 26px | `Text/Heading` | BottomSheet titles |
| `Headline/Medium` | Public Sans | 16 | 600 (SemiBold) | 24px | `Text/Heading` | TopAppBar title, card titles |
| `Title/Large` | Public Sans | 16 | 500 (Medium) | 24px | `Text/Primary` | List card primary title |
| `Title/Medium` | Public Sans | 14 | 500 (Medium) | 20px | `Text/Primary` | Form section headers |
| `Body/Large` | Public Sans | 15 | 400 (Regular) | 22px | `Text/Primary` | Body paragraphs |
| `Body/Medium` | Public Sans | 13 | 400 (Regular) | 18px | `Text/Secondary` | Subtitles, list card secondary info |
| `Label/Large` | Public Sans | 12 | 600 (SemiBold) | 16px | `Text/OnSurface` | Input field labels (floating), chip labels |
| `Label/Small` | Public Sans | 11 | 400 (Regular) | 14px | `Text/Secondary` | Captions, bottom nav labels, helper text |
| `Button/Text` | Public Sans | 14 | 600 (SemiBold) | 20px | `Text/OnPrimary` | Button labels — UPPERCASE OFF |

---

## 1.3 Spacing Tokens (Number Variables)

**How to create:** `Local Variables → + Create Variable → Number`

| Variable Name | Value (px) | Usage |
|---|---|---|
| `Spacing/XS` | 4 | Micro gaps, status chip inner padding |
| `Spacing/SM` | 8 | Small gaps between related elements |
| `Spacing/MD` | 16 | Screen margins, card padding |
| `Spacing/LG` | 24 | Section spacing, BottomSheet padding |
| `Spacing/XL` | 32 | Large vertical spacing |
| `Spacing/2XL` | 48 | Hero section vertical padding |

---

## 1.4 Effects (Shadows)

**How to create:** Select any frame → `Design panel → Effects → + → Drop Shadow` → enter values.
Then: `Styles panel (4-dot icon) → + → create as Style.`

### Card Shadow — `shadow/card`
| Property | Value |
|---|---|
| Type | Drop Shadow |
| X | 0 |
| Y | 2 |
| Blur | 8 |
| Spread | 0 |
| Color | `#00000014` (Black at 8% opacity) |

### Bottom Sheet Shadow — `shadow/bottomSheet`
| Property | Value |
|---|---|
| Type | Drop Shadow |
| X | 0 |
| Y | -4 |
| Blur | 16 |
| Spread | 0 |
| Color | `#0000001a` (Black at 10% opacity) |

### FAB Shadow — `shadow/fab`
| Property | Value |
|---|---|
| Type | Drop Shadow |
| X | 0 |
| Y | 4 |
| Blur | 12 |
| Spread | 0 |
| Color | `#696cff40` (Primary at 25% opacity) |

### Bottom Nav Shadow — `shadow/bottomNav`
| Property | Value |
|---|---|
| Type | Drop Shadow |
| X | 0 |
| Y | -1 |
| Blur | 4 |
| Spread | 0 |
| Color | `#0000000f` (Black at 6% opacity) |

### TopAppBar Shadow — `shadow/topBar`
| Property | Value |
|---|---|
| Type | Drop Shadow |
| X | 0 |
| Y | 2 |
| Blur | 8 |
| Spread | 0 |
| Color | `#00000014` (same as card) |

---

---

# SECTION 2 — Base Components Library

> **CRITICAL Figma setup rule:** Every component below must be created as a **Component** (`Cmd/Ctrl + Alt + K`) with **Variants** for each state. Use Auto Layout on every single component — no fixed-position frames.

---

## 2.1 Primary Button Component

**Figma Component name:** `Button/Primary`
**Variants:** `State = Default`, `State = Disabled`, `State = Loading`

### Structure (Auto Layout)

```
[Button/Primary] — Frame
  Direction: Horizontal
  Width: Fill Container (when placed inside a parent)
  Height: Fixed 48px
  Horizontal Padding: 16px (left & right)
  Vertical Padding: 0px
  Gap: 8px (between icon and label if icon is present)
  Alignment: Center (horizontal & vertical)
  Corner Radius: 8px
  Clip Content: ON

  Children:
  ├── [Spinner Icon] — only visible in Loading state
  │     Type: SVG / Component (circular spinner)
  │     Size: 20×20px
  │     Color: #ffffff
  │     Visibility: Hidden in Default/Disabled
  │
  └── [Label] — Text
        Style: Button/Text (14px · Weight 600 · Public Sans)
        Text: "SIGN IN" (all caps OFF)
        Color: #ffffff
```

### State Definitions

| Property | Default | Disabled | Loading |
|---|---|---|---|
| Fill | `#696cff` | `#b9b9b9` | `#696cff` |
| Spinner Visibility | Hidden | Hidden | Visible |
| Label Visibility | Visible | Visible | Hidden |
| Label Text Color | `#ffffff` | `#ffffff` | — |
| Interaction | Enabled | Layer: Disabled (Figma) | Disabled |
| Opacity | 100% | 100% | 100% |

---

## 2.2 Text Input Field Component

**Figma Component name:** `Input/TextField`
**Variants:** `State = Default`, `State = Focused`, `State = Error`, `State = Disabled`, `State = Valid`

### Structure (Auto Layout)

```
[Input/TextField] — Frame (the full label + input + helper group)
  Direction: Vertical
  Width: Fill Container
  Height: Hug Contents
  Gap: 4px
  Padding: 0px
  Alignment: Left

  Children:
  ├── [Label] — Text (ABOVE input)
  │     Style: Label/Large (12px · Weight 600)
  │     Color: #697a8d (default), #696cff (focused), #ea5455 (error)
  │     Visibility: Always visible
  │
  ├── [InputBox] — Frame (the border + content area)
  │     Direction: Horizontal
  │     Width: Fill Container
  │     Height: Fixed 52px
  │     Padding: 14px (all sides)
  │     Gap: 8px
  │     Corner Radius: 8px
  │     Stroke: 1px, Color: #e7e7e8 (default), 1.5px #696cff (focused), 1.5px #ea5455 (error)
  │     Fill: #ffffff (default/focused/error), #f5f5f9 (disabled)
  │     Alignment: Center (vertical)
  │
  │     Children:
  │     ├── [Prefix Icon] — SVG · Material Symbols Rounded
  │     │     Size: 20×20px · Color: #8592a3
  │     │     Visibility: Conditional (show only if icon needed)
  │     │
  │     ├── [Input Text] — Text · Fill Container
  │     │     Style: Body/Large (15px · Weight 400)
  │     │     Color: #333333 (typed), #8592a3 (placeholder)
  │     │
  │     └── [Suffix Icon] — SVG · e.g., eye toggle, clear button
  │           Size: 20×20px · Color: #8592a3
  │           Visibility: Conditional
  │
  └── [HelperText] — Text
        Style: Label/Small (11px · Weight 400)
        Color: #ea5455 (error), #8592a3 (default hint)
        Visibility: Hidden in Default/Focused, Visible in Error
        Content: "This field is required."
```

### State-by-State Stroke & Color Rules

| Property | Default | Focused | Error | Disabled | Valid |
|---|---|---|---|---|---|
| Stroke Weight | 1px | 1.5px | 1.5px | 1px (dashed) | 1px |
| Stroke Color | `#e7e7e8` | `#696cff` | `#ea5455` | `#e7e7e8` | `#28c76f` |
| Label Color | `#697a8d` | `#696cff` | `#ea5455` | `#b9b9b9` | `#697a8d` |
| Fill | `#ffffff` | `#ffffff` | `#ffffff` | `#f5f5f9` | `#ffffff` |
| Helper Text | Hidden | Hidden | Visible (red) | Hidden | Hidden |

---

## 2.3 Status Chip Component

**Figma Component name:** `Chip/Status`
**Variants:** `Status = Active`, `Status = Inactive`

### Structure (Auto Layout)

```
[Chip/Status] — Frame
  Direction: Horizontal
  Width: Hug Contents
  Height: Hug Contents
  Padding: Top 3px, Bottom 3px, Left 8px, Right 8px
  Gap: 4px
  Corner Radius: 999px (fully rounded)
  Alignment: Center (vertical)

  Children:
  ├── [Dot] — Ellipse
  │     Size: 6×6px
  │     Fill: #28c76f (Active), #ea5455 (Inactive)
  │
  └── [Label] — Text
        Style: Label/Small (11px · Weight 400)
        Color: #28c76f (Active), #ea5455 (Inactive)
        Content: "Active" or "Inactive"
```

### Variant Fills

| Variant | Background Fill | Dot Color | Text Color |
|---|---|---|---|
| Active | `#e8f8ee` | `#28c76f` | `#28c76f` |
| Inactive | `#fce8e8` | `#ea5455` | `#ea5455` |

---

## 2.4 Bottom Navigation Bar Component

**Figma Component name:** `Nav/BottomBar`
This is a full-width bar containing 4 Nav Items.

### Bar Structure (Auto Layout)

```
[Nav/BottomBar] — Frame
  Direction: Horizontal
  Width: Fill Container (390px when placed on screen)
  Height: Fixed 64px
  Padding: 0px horizontal, 0px vertical
  Gap: 0px (items use Fill Container each)
  Fill: #ffffff
  Effects: shadow/bottomNav
  Alignment: Center (vertical)
```

### Nav Item Sub-component — `Nav/BottomItem`
**Variants:** `State = Inactive`, `State = Active`

```
[Nav/BottomItem] — Frame
  Direction: Vertical
  Width: Fill Container (1/4 of bar = ~97px)
  Height: Fill Container (64px)
  Padding: 8px top, 4px bottom, 0px horizontal
  Gap: 2px
  Alignment: Center (horizontal & vertical)

  Children:
  ├── [Icon Container] — Frame (for active indicator pill)
  │     Direction: Horizontal
  │     Width: Hug Contents
  │     Height: Hug Contents
  │     Padding: 4px vertical, 16px horizontal
  │     Corner Radius: 999px
  │     Fill: #e7e7ff (Active state ONLY), Transparent (Inactive)
  │
  │     Children:
  │     └── [Icon] — SVG · Material Symbols Rounded
  │           Size: 24×24px
  │           Color: #696cff (Active), #8592a3 (Inactive)
  │
  └── [Label] — Text
        Style: Label/Small (11px · Weight 400)
        Color: #696cff (Active), #8592a3 (Inactive)
        Content: "Home", "Cities", "Hospitals", "More"
```

### 4 Tab Items

| Tab | Icon (Material Symbols Rounded) | Label | Active Tab |
|---|---|---|---|
| Tab 1 | `home` | Home | On Dashboard screen |
| Tab 2 | `location_city` | Cities | On City List screen |
| Tab 3 | `local_hospital` | Hospitals | On Hospital List screen |
| Tab 4 | `more_horiz` | More | On More screen |

---

## 2.5 Floating Action Button (FAB) Component

**Figma Component name:** `FAB/Primary`
**Variants:** `State = Default`, `State = Loading`

### Structure (Auto Layout)

```
[FAB/Primary] — Frame
  Direction: Horizontal
  Width: Fixed 56px
  Height: Fixed 56px
  Padding: 0px
  Gap: 0px
  Corner Radius: 16px
  Fill: #696cff
  Effects: shadow/fab
  Alignment: Center (horizontal & vertical)
  Position: Absolute (when placed on screen · bottom-right · 16px from edges)

  Children:
  └── [Icon] — SVG · Material Symbols Rounded
        Icon Name: `add`
        Size: 24×24px
        Color: #ffffff
```

---

## 2.6 List Card Component

**Figma Component name:** `Card/ListItem`

### Structure (Auto Layout)

```
[Card/ListItem] — Frame
  Direction: Horizontal
  Width: Fill Container
  Height: Hug Contents (min 72px)
  Padding: 12px top/bottom, 16px left/right
  Gap: 12px
  Corner Radius: 12px
  Fill: #ffffff
  Effects: shadow/card
  Alignment: Center (vertical)

  Children:
  ├── [Avatar] — Frame
  │     Width: Fixed 48px
  │     Height: Fixed 48px
  │     Corner Radius: 10px
  │     Fill: #e7e7ff (when no image)
  │     Clip Content: ON
  │
  │     Children:
  │     └── [PlaceholderIcon] — SVG · 22×22px · #696cff
  │           (Replace with ImageRectangle when image exists)
  │
  ├── [ContentBlock] — Frame · Fill Container
  │     Direction: Vertical
  │     Width: Fill Container
  │     Height: Hug Contents
  │     Gap: 3px
  │     Padding: 0px
  │     Alignment: Left
  │
  │     Children:
  │     ├── [Title] — Text · Fill Container
  │     │     Style: Title/Large (16px · Weight 500 · #333333)
  │     ├── [Subtitle] — Text · Fill Container
  │     │     Style: Body/Medium (13px · Weight 400 · #8592a3)
  │     └── [Chip/Status] — Component Instance
  │
  └── [MenuIcon] — Frame · Absolute position (right-aligned)
        Width: 32px · Height: 32px
        Fill: Transparent
        Icon: `more_vert` · 20×20px · #8592a3
```

---

## 2.7 Stat Card Component (Dashboard)

**Figma Component name:** `Card/Stat`

### Structure (Auto Layout)

```
[Card/Stat] — Frame
  Direction: Vertical
  Width: Fill Container (in a 2-column grid, this = (390 - 16 - 16 - 12) / 2 = 173px)
  Height: Fixed 100px
  Padding: 16px (all sides)
  Gap: 4px
  Corner Radius: 12px
  Fill: #ffffff
  Effects: shadow/card
  Alignment: Left (horizontal), Top (vertical)

  Children:
  ├── [IconContainer] — Frame
  │     Width: Fixed 40px
  │     Height: Fixed 40px
  │     Corner Radius: 10px
  │     Fill: #e7e7ff
  │     Alignment: Center (horizontal & vertical)
  │
  │     Children:
  │     └── [Icon] — SVG · 22×22px · #696cff
  │
  ├── [Value] — Text
  │     Style: Display/Large (24px · Weight 700 · #333333)
  │     Content: "12" (dynamic)
  │
  └── [Label] — Text
        Style: Label/Large (12px · Weight 600 · #8592a3)
        Content: "Cities" (dynamic)
```

---

## 2.8 Image Upload Placeholder Component

**Figma Component name:** `Input/ImageUpload`
**Variants:** `State = Empty`, `State = Preview`, `State = Uploading`

### Empty State Structure (Auto Layout)

```
[Input/ImageUpload] — Frame
  Direction: Vertical
  Width: Fill Container
  Height: Fixed 120px
  Padding: 0px
  Corner Radius: 12px
  Fill: #f5f5f9
  Stroke: 1.5px Dashed · #dbdade
  Alignment: Center (horizontal & vertical)
  Gap: 6px

  Children:
  ├── [CameraIcon] — SVG · 32×32px · #8592a3
  │     Icon: `add_photo_alternate`
  ├── [PrimaryText] — Text
  │     Style: Body/Medium (13px · Weight 400 · #566a7f)
  │     Content: "Tap to add photo"
  └── [HintText] — Text
        Style: Label/Small (11px · Weight 400 · #8592a3)
        Content: "PNG, JPG · Max 5MB"
```

### Preview State (image selected)
- Replace inner children with `[ImageRectangle]` (Width: Fill, Height: Fill, Corner: 12px, Clip Content: ON)
- Add `[RemoveButton]` using **Absolute Position**: Top-Right, X offset: -8px, Y offset: -8px
  - Size: 24×24px · Corner: 999px · Fill: #ea5455 · Icon: `close` · 14×14px · white

---

---

# SECTION 3 — Screen-by-Screen Blueprint (Node Tree Structure)

> **Frame Setup for all screens:**
> - Frame Size: **390 × 844px**
> - Background Fill: `#f5f5f9`
> - Clip Content: **ON**
> - Grid: 4-Column · Margin 16px · Gutter 16px (for reference only, not exported)

---

## Screen 1 — Login Screen

**Frame name:** `02_Login`
**Background:** Linear Gradient · Angle: 180° · Stop 1: `#f5f5f9` at 0% · Stop 2: `#eeeeff` at 100%

### Full Node Tree

```
[02_Login] — Frame (390×844) · Gradient BG
│
├── [StatusBar] — Frame (Absolute Position)
│     Width: 390px · Height: 44px · Top: 0 · Left: 0
│     Fill: Transparent (status bar is transparent)
│
└── [ContentRoot] — Frame (Auto Layout)
      Direction: Vertical
      Width: Fill Container (390px)
      Height: Fill Container (844px)
      Padding: 0px top, 0px bottom, 0px horizontal
      Gap: 0px
      Alignment: Center (horizontal), Top (vertical)
      ↳ Holds: StatusBarSpacer + ScrollableContent

      ├── [StatusBarSpacer] — Frame
      │     Width: Fill Container · Height: Fixed 44px
      │     Fill: Transparent
      │
      └── [ScrollableContent] — Frame
            Direction: Vertical
            Width: Fill Container
            Height: Fill Container (Hug)
            Padding: 32px top, 24px bottom, 24px left, 24px right
            Gap: 24px
            Overflow: Scroll (vertical) — mark as scrollable in prototype
            Alignment: Center (horizontal)

            ├── [BrandBlock] — Frame
            │     Direction: Vertical
            │     Width: Fill Container
            │     Height: Hug Contents
            │     Padding: 0px
            │     Gap: 8px
            │     Alignment: Center (horizontal)
            │
            │     ├── [LogoImage] — Rectangle
            │     │     Width: Fixed 120px · Height: Fixed 120px
            │     │     Corner Radius: 16px
            │     │     Fill: Image (logo.png · Goal Foundation logo)
            │     │     Fit: Contain
            │     │
            │     ├── [AppName] — Text
            │     │     Style: Display/Large (24px · Bold · #333333)
            │     │     Content: "Goal Foundation"
            │     │     Alignment: Center
            │     │
            │     └── [AppSubtitle] — Text
            │           Style: Body/Medium (13px · Regular · #8592a3)
            │           Content: "Animal Birth Control"
            │           Alignment: Center
            │
            ├── [LoginCard] — Frame
            │     Direction: Vertical
            │     Width: Fill Container
            │     Height: Hug Contents
            │     Padding: 24px (all sides)
            │     Gap: 16px
            │     Corner Radius: 20px
            │     Fill: #ffffff
            │     Effects: shadow/card
            │
            │     ├── [CardHeader] — Frame
            │     │     Direction: Vertical
            │     │     Width: Fill Container
            │     │     Height: Hug Contents
            │     │     Gap: 4px
            │     │     Padding: 0px 0px 8px 0px (bottom margin)
            │     │
            │     │     ├── [CardTitle] — Text
            │     │     │     Style: Headline/Large (18px · SemiBold · #333333)
            │     │     │     Content: "Welcome Back 🐾"
            │     │     │
            │     │     └── [CardSubtitle] — Text
            │     │           Style: Body/Medium (13px · Regular · #8592a3)
            │     │           Content: "Sign in to continue"
            │     │
            │     ├── [Divider] — Rectangle
            │     │     Width: Fill Container · Height: 1px
            │     │     Fill: #dbdade
            │     │
            │     ├── [EmailField] — Component Instance (Input/TextField)
            │     │     State: Default
            │     │     Label Text: "Email Address"
            │     │     Placeholder: "email@goalf.org"
            │     │     Prefix Icon: `mail_outline`
            │     │     Width: Fill Container
            │     │
            │     ├── [PasswordField] — Component Instance (Input/TextField)
            │     │     State: Default
            │     │     Label Text: "Password"
            │     │     Placeholder: "••••••••"
            │     │     Prefix Icon: `lock_outline`
            │     │     Suffix Icon: `visibility_off` (toggle)
            │     │     Width: Fill Container
            │     │
            │     ├── [RememberMeRow] — Frame
            │     │     Direction: Horizontal
            │     │     Width: Fill Container
            │     │     Height: Hug Contents
            │     │     Gap: 8px
            │     │     Padding: 0px
            │     │     Alignment: Center (vertical)
            │     │
            │     │     ├── [Checkbox] — Square 20×20px
            │     │     │     Corner: 4px · Stroke: 1.5px #696cff
            │     │     │     Fill: Transparent (unchecked) / #696cff (checked)
            │     │     │
            │     │     └── [RememberLabel] — Text
            │     │           Style: Body/Medium (13px · #566a7f)
            │     │           Content: "Remember Me"
            │     │
            │     └── [SignInButton] — Component Instance (Button/Primary)
            │           State: Default
            │           Label: "SIGN IN"
            │           Width: Fill Container
            │
            └── [FooterText] — Text
                  Style: Label/Small (11px · Regular · #8592a3)
                  Content: "Powered by IV Infotech"
                  Alignment: Center
                  Width: Fill Container
```

---

## Screen 2 — Dashboard (Home Screen)

**Frame name:** `03_Dashboard`
**Background:** Fill `#f5f5f9`

### Full Node Tree

```
[03_Dashboard] — Frame (390×844)
│
├── [StatusBar] — Frame · Absolute Position
│     Width: 390px · Height: 44px · Top: 0 · Left: 0 · Fill: Transparent
│
├── [TopAppBar] — Frame · Absolute Position
│     Width: 390px · Height: 56px · Top: 44px · Left: 0
│     Direction: Horizontal
│     Padding: 0px 16px
│     Gap: 8px
│     Fill: #ffffff
│     Effects: shadow/topBar
│     Alignment: Center (vertical)
│
│     ├── [MenuIcon] — Icon · `menu` · 24×24px · #566a7f
│     ├── [TitleBlock] — Frame · Fill Container · Vertical · Gap: 1px
│     │     ├── [Title] — Text: "ABC Dashboard" · Headline/Medium · #333333
│     │     └── [Subtitle] — Text: "Goal Foundation" · Label/Small · #8592a3
│     ├── [Spacer] — Frame · Fill Container
│     ├── [NotifIcon] — Icon · `notifications_none` · 24×24px · #566a7f
│     └── [AvatarCircle] — Frame · 36×36px · Corner 999px · Fill: #e7e7ff
│           └── [Initial] — Text: "A" · 14px · Bold · #696cff
│
├── [ScrollContent] — Frame · Absolute Position
│     Top: 100px (StatusBar 44 + TopBar 56) · Left: 0 · Right: 0 · Bottom: 64px
│     Direction: Vertical
│     Width: 390px
│     Height: 680px (844 - 44 - 56 - 64)
│     Overflow: Scroll (vertical)
│     Padding: 16px (all sides)
│     Gap: 16px
│
│     ├── [HeroCard] — Frame
│     │     Direction: Vertical
│     │     Width: Fill Container
│     │     Height: Hug Contents
│     │     Padding: 20px (all sides)
│     │     Gap: 12px
│     │     Corner Radius: 16px
│     │     Fill: Linear Gradient · 90° · #696cff → #9c9eff
│     │     Clip Content: ON
│     │
│     │     ├── [Greeting] — Text
│     │     │     Content: "🐾  Good morning, Admin!"
│     │     │     Style: Headline/Medium · #ffffff
│     │     │
│     │     ├── [GreetingSubtitle] — Text
│     │     │     Content: "Here's your daily overview"
│     │     │     Style: Body/Medium · #ffffff (at 80% opacity)
│     │     │
│     │     └── [ProgressBarPlaceholder] — Frame
│     │           Width: Fill Container · Height: 6px
│     │           Corner: 999px · Fill: #ffffff (at 30% opacity)
│     │           ↳ Inner progress fill: Width: 72% · Fill: #ffffff
│     │
│     ├── [SectionLabel] — Text
│     │     Content: "Master Data Overview"
│     │     Style: Label/Large · #697a8d
│     │     Width: Fill Container
│     │
│     └── [StatsGrid] — Frame
│           Direction: Vertical
│           Width: Fill Container
│           Height: Hug Contents
│           Gap: 12px
│           Padding: 0px
│
│           ├── [GridRow1] — Frame
│           │     Direction: Horizontal
│           │     Width: Fill Container
│           │     Height: Hug Contents
│           │     Gap: 12px
│           │     ├── [Card/Stat] Cities · Icon: location_city · Value: "12" · Label: "Cities"
│           │     └── [Card/Stat] NGOs   · Icon: handshake   · Value: "09" · Label: "NGOs"
│           │
│           ├── [GridRow2] — Frame
│           │     Direction: Horizontal · Width: Fill Container · Gap: 12px
│           │     ├── [Card/Stat] Hospitals · Icon: local_hospital · Value: "08"
│           │     └── [Card/Stat] Doctors   · Icon: medical_services · Value: "26"
│           │
│           └── [GridRow3] — Frame
│                 Direction: Horizontal · Width: Fill Container · Gap: 12px
│                 ├── [Card/Stat] Vehicles · Icon: airport_shuttle · Value: "17"
│                 └── [Card/Stat] Staff    · Icon: group           · Value: "39"
│
└── [Nav/BottomBar] — Component Instance · Absolute Position
      Width: 390px · Height: 64px · Bottom: 0 · Left: 0
      Active Tab: Tab 1 (Home)
```

### Shimmer Skeleton State (Loading)

Create a separate Variant of this screen or a separate component `Card/StatShimmer`:

```
[Card/StatShimmer] — same dimensions as Card/Stat (Fill Container × 100px)
  Corner: 12px · Fill: #ffffff · Effects: shadow/card
  ↳ All inner elements replaced with:
      [ShimmerBlock] — Rectangle · Fill: Linear Gradient animated
        · Gradient: #f0f0f0 → #e0e0e0 → #f0f0f0 · Angle: 90°
        · Annotate: "Apply shimmer animation in Android"
```

---

## Screen 3 — Master Data List Screen (City / Hospital / NGO / Doctor / Vehicle)

**Frame name:** `04_City_List` (duplicate and rename for each entity)
**Background:** Fill `#f5f5f9`

> This screen is a template. The TopAppBar title and card content fields change per entity.

### Full Node Tree

```
[04_City_List] — Frame (390×844)
│
├── [StatusBar] — Absolute · 390×44px · Top: 0 · Transparent
│
├── [TopAppBar] — Frame · Absolute Position
│     Top: 44 · Left: 0 · Width: 390px · Height: 56px
│     Direction: Horizontal
│     Padding: 4px 4px
│     Gap: 0px
│     Fill: #ffffff
│     Effects: shadow/topBar
│     Alignment: Center (vertical)
│
│     ├── [BackButton] — IconButton · 48×48px
│     │     Icon: `arrow_back` · 24×24px · #566a7f
│     │
│     ├── [ScreenTitle] — Text · Fill Container
│     │     Style: Headline/Medium · #333333
│     │     Content: "Cities"
│     │
│     └── [SearchButton] — IconButton · 48×48px
│           Icon: `search` · 24×24px · #566a7f
│
├── [ScrollContent] — Frame · Absolute Position
│     Top: 100px · Left: 0 · Width: 390px · Height: 680px
│     Direction: Vertical
│     Overflow: Scroll (vertical)
│     Padding: 12px (all sides)
│     Gap: 8px
│
│     ├── [FilterChipRow] — Frame
│     │     Direction: Horizontal
│     │     Width: Fill Container
│     │     Height: Hug Contents
│     │     Gap: 8px
│     │     Overflow: Scroll (horizontal)
│     │     Padding: 0px 4px
│     │
│     │     ├── [ChipAll] — Frame · Hug · Padding: 6px 16px · Corner: 999px
│     │     │     Fill: #696cff (SELECTED) · Text: "All" · #ffffff · Label/Small
│     │     ├── [ChipActive] — Frame · same · Fill: #e7e7ff · Text: #696cff
│     │     └── [ChipInactive] — Frame · same · Fill: #e7e7ff · Text: #696cff
│     │
│     ├── [Card/ListItem] — Component Instance × N (repeat for each item)
│     │     Each card: Width: Fill Container · Margin bottom: 0 (gap handles it)
│     │     City variant:
│     │       Avatar: city image thumbnail or placeholder (location_city icon)
│     │       Title: "Rajkot"
│     │       Subtitle: "Created Apr 3, 2026"
│     │       Chip: Active
│     │
│     └── [EmptyState] — Frame (show when list is empty)
│           Direction: Vertical
│           Width: Fill Container
│           Height: Hug Contents
│           Padding: 48px vertical, 24px horizontal
│           Gap: 12px
│           Alignment: Center (horizontal)
│
│           ├── [EmptyIcon] — SVG · 80×80px · #dbdade
│           │     Icon: `inbox` or `location_city`
│           ├── [EmptyTitle] — Text: "No Cities found yet."
│           │     Style: Headline/Medium · #566a7f · Center
│           ├── [EmptyBody] — Text: "Tap + to add your first city."
│           │     Style: Body/Medium · #8592a3 · Center
│           └── [OutlinedButton] — Frame
│                 Direction: Horizontal · Hug · Padding: 10px 20px · Corner: 8px
│                 Stroke: 1.5px #696cff · Fill: Transparent · Gap: 6px
│                 ├── [Icon] `add` · 18×18px · #696cff
│                 └── [Label] "+ ADD CITY" · Button/Text · Color: #696cff
│
├── [FAB/Primary] — Component Instance · Absolute Position
│     Bottom: 80px (64 nav + 16 margin) · Right: 16px
│     (Positioned above Bottom Nav)
│
└── [Nav/BottomBar] — Absolute Position · Bottom: 0 · Width: 390px
      Active Tab: Tab 2 (Cities) — for City List
```

---

## Screen 4A — Add City (ModalBottomSheet)

**Frame name:** `05_City_Add_BottomSheet`

> Design as a Modal Bottom Sheet overlay on top of the City List screen. In Figma, create as a separate frame (390×844) with a dimmed background + the bottom sheet panel anchored to the bottom.

### Node Tree

```
[05_City_Add_BottomSheet] — Frame (390×844)
│
├── [Scrim] — Rectangle · Absolute Position
│     Width: 390px · Height: 844px · Top: 0 · Left: 0
│     Fill: #000000 at 40% opacity
│     (Tap to dismiss — prototype interaction)
│
└── [BottomSheetPanel] — Frame · Absolute Position
      Width: 390px
      Height: Hug Contents (max ~480px for this form)
      Bottom: 0 · Left: 0
      Direction: Vertical
      Padding: 0px (outer frame)
      Corner Radius: 20px top-left, 20px top-right, 0px bottom
      Fill: #ffffff
      Effects: shadow/bottomSheet
      Clip Content: ON

      ├── [HandleBar] — Frame
      │     Direction: Horizontal
      │     Width: Fill Container
      │     Height: 24px (includes top padding)
      │     Padding: 8px top, 8px bottom
      │     Alignment: Center (horizontal)
      │
      │     └── [Handle] — Rectangle
      │           Width: 32px · Height: 4px
      │           Corner: 999px · Fill: #dbdade
      │
      ├── [SheetContent] — Frame
      │     Direction: Vertical
      │     Width: Fill Container
      │     Height: Hug Contents
      │     Padding: 0px 24px 0px 24px
      │     Gap: 16px
      │
      │     ├── [SheetTitle] — Text
      │     │     Style: Headline/Large · #333333
      │     │     Content: "Add New City"
      │     │
      │     ├── [Divider] — Rectangle · Fill Container × 1px · #dbdade
      │     │
      │     ├── [CityNameField] — Component Instance (Input/TextField)
      │     │     State: Default
      │     │     Label: "City Name *"
      │     │     Placeholder: "Enter city name"
      │     │     Width: Fill Container
      │     │
      │     ├── [ImageUploadSection] — Frame
      │     │     Direction: Vertical
      │     │     Width: Fill Container
      │     │     Height: Hug Contents
      │     │     Gap: 6px
      │     │
      │     │     ├── [ImageLabel] — Text: "City Image" · Label/Large · #697a8d
      │     │     │
      │     │     └── [Input/ImageUpload] — Component Instance
      │     │           State: Empty
      │     │           Width: Fill Container
      │     │           Height: 120px
      │     │           (Design all 3 states as Variants)
      │     │
      │     └── [BottomSpacer] — Frame · Width: Fill · Height: 12px
      │
      └── [StickyFooter] — Frame
            Direction: Horizontal
            Width: Fill Container
            Height: Hug Contents (≈76px with safe area)
            Padding: 12px 16px
            Gap: 0px
            Fill: #ffffff
            (Separate from scroll — this always sticks to bottom)

            └── [SaveButton] — Component Instance (Button/Primary)
                  Label: "SAVE CITY"
                  Width: Fill Container
                  Height: 52px
                  Corner: 10px (override from default 8px)
```

---

## Screen 4B — Add Hospital (Full-Screen Activity)

**Frame name:** `09_Hospital_Add_Full`
**Background:** Fill `#f5f5f9`

### Full Node Tree

```
[09_Hospital_Add_Full] — Frame (390×844)
│
├── [StatusBar] — Absolute · 390×44px · Transparent
│
├── [TopAppBar] — Frame · Absolute Position
│     Top: 44 · Width: 390px · Height: 56px
│     Direction: Horizontal · Padding: 4px · Gap: 0px
│     Fill: #ffffff · Effects: shadow/topBar
│     Alignment: Center (vertical)
│
│     ├── [BackButton] — IconButton · 48×48px · `arrow_back` · #566a7f
│     ├── [ScreenTitle] — Text · Fill · "Add Hospital" · Headline/Medium · #333333
│     └── [Spacer] — Fill Container
│
└── [ScrollContent] — Frame · Absolute Position
      Top: 100px · Bottom: 76px (leaves room for sticky button)
      Width: 390px · Overflow: Scroll (vertical)
      Direction: Vertical · Padding: 16px · Gap: 16px

      ├── [ImageSection] — Frame
      │     Direction: Vertical · Width: Fill · Gap: 6px
      │     ├── [SectionLabel] — Text: "── Hospital Image ──" · Label/Large · #697a8d
      │     └── [Input/ImageUpload] · State: Empty · Width: Fill · Height: 160px
      │
      ├── [BasicInfoSection] — Frame
      │     Direction: Vertical · Width: Fill · Gap: 12px
      │     ├── [SectionLabel] — "── Basic Information ──" · Label/Large · #697a8d
      │     ├── [HospitalNameField] — Input/TextField · Label: "Hospital Name *"
      │     ├── [CityDropdown] — Frame (replicate Input styling + dropdown arrow)
      │     │     Label: "City *"
      │     │     ↳ Suffix Icon: `expand_more` · #566a7f
      │     ├── [ContactField] — Input/TextField · Label: "Contact Number *"
      │     │     Prefix Icon: `phone` · InputType annotation: numeric
      │     └── [EmailField] — Input/TextField · Label: "Email Address" (optional)
      │           Prefix Icon: `mail_outline`
      │
      ├── [RFIDSection] — Frame
      │     Direction: Vertical · Width: Fill · Gap: 12px
      │     ├── [SectionLabel] — "── Login & RFID ──" · Label/Large · #697a8d
      │     ├── [PINField] — Input/TextField · Label: "Hospital PIN *"
      │     │     Helper: "4-digit numeric PIN" · Suffix Icon: `visibility_off`
      │     ├── [RFIDStartField] — Input/TextField · Label: "RFID Tag Start"
      │     ├── [RFIDEndField]   — Input/TextField · Label: "RFID Tag End"
      │     └── [NetQtyField]    — Input/TextField · Label: "Net Quantity (Catching Nets) *"
      │
      └── [AddressSection] — Frame
            Direction: Vertical · Width: Fill · Gap: 12px
            ├── [SectionLabel] — "── Address ──" · Label/Large · #697a8d
            └── [AddressField] — Input/TextField · Label: "Address"
                  Height: Fixed 96px (multi-line · min 3 lines)
                  Annotation: "textMultiLine in Android"

[StickyFooterContainer] — Frame · Absolute Position
  Bottom: 0 · Left: 0 · Width: 390px · Height: 76px
  Fill: #ffffff · Effects: shadow/bottomSheet (inverted — shadow goes UP)
  Direction: Horizontal · Padding: 12px 16px
  ↳ [SaveButton] — Button/Primary · Label: "SAVE HOSPITAL" · Fill Container × 52px
```

---

## Screen 5 — More Screen

**Frame name:** `14_More_Screen`

### Full Node Tree

```
[14_More_Screen] — Frame (390×844)
│
├── [StatusBar] — Absolute · 390×44px · Transparent
│
├── [TopAppBar] — Absolute · Top: 44 · Width: 390px · Height: 56px
│     ├── [BackIcon] `arrow_back` · #566a7f
│     ├── [Title] "More" · Headline/Medium · #333333
│     └── [Spacer] Fill Container
│
├── [ScrollContent] — Absolute · Top: 100 · Bottom: 64 · Width: 390px
│     Direction: Vertical · Padding: 16px · Gap: 8px · Overflow: Scroll
│
│     ├── [ModulesSection] — Frame
│     │     Direction: Vertical · Width: Fill · Gap: 8px
│     │
│     │     ├── [MoreCard_NGO] — Frame (same as Card/ListItem but simplified)
│     │     │     Direction: Horizontal · Width: Fill · Height: 60px
│     │     │     Padding: 12px 16px · Corner: 12px · Fill: #ffffff · Effects: shadow/card
│     │     │     Alignment: Center (vertical) · Gap: 12px
│     │     │     ├── [Icon] `handshake` · 24px · #696cff container 40×40 · BG #e7e7ff
│     │     │     ├── [TextBlock] Fill Container · Vertical
│     │     │     │     ├── [Title] "NGOs" · Title/Large · #333333
│     │     │     │     └── [Sub]  "9 active NGOs" · Body/Medium · #8592a3
│     │     │     └── [Chevron] `chevron_right` · 20px · #8592a3
│     │     │
│     │     ├── [MoreCard_Doctors] — same structure
│     │     │     Icon: `medical_services` · Title: "Doctors" · Sub: "26 doctors"
│     │     │
│     │     └── [MoreCard_Vehicles] — same structure
│     │           Icon: `airport_shuttle` · Title: "Vehicles" · Sub: "17 vehicles"
│     │
│     ├── [SectionDivider] — Frame · Width: Fill · Height: Hug · Padding: 8px 0
│     │     Direction: Horizontal · Gap: 8px · Alignment: Center (vertical)
│     │     ├── [Line] Fill Container × 1px · Fill: #dbdade
│     │     ├── [Label] "Settings" · Label/Small · #8592a3
│     │     └── [Line] Fill Container × 1px · Fill: #dbdade
│     │
│     ├── [MoreCard_Profile] — same structure
│     │     Icon: `person_outline` · Title: "My Profile" · Sub: "Super Admin"
│     │
│     └── [MoreCard_Logout] — same but danger colored
│           Icon: `logout` · Color: #ea5455
│           Title: "Logout" · Title/Large · #ea5455
│           NO chevron icon
│
└── [Nav/BottomBar] — Absolute · Bottom: 0 · Active Tab: Tab 4 (More)
```

---

---

# SECTION 4 — State Screens (Required for Complete Prototype)

---

## 4.1 Empty State Template

Used on all List screens when API returns 0 results.

```
[EmptyState] — Frame
  Direction: Vertical · Width: Fill Container · Height: Hug
  Padding: 48px vertical, 24px horizontal · Gap: 12px · Alignment: Center

  ├── [EmptyIllustration] — SVG / Rectangle placeholder
  │     80×80px · Fill: #dbdade (or use Material `inbox` icon)
  ├── [EmptyTitle] — Headline/Medium · #566a7f · "No [Entity] found yet."
  ├── [EmptyBody]  — Body/Medium · #8592a3 · "Tap + to add one."
  └── [OutlinedButton] — Stroke: 1.5px #696cff · Padding: 10px 20px · Corner: 8px
        Label: "+ ADD [ENTITY]" · Button/Text · Color: #696cff
```

## 4.2 Error State Template

```
[ErrorState] — Frame · same Auto Layout as Empty State

  ├── [ErrorIcon] — `warning_amber` · 80×80px · #ff9f43
  ├── [ErrorTitle] — "Something went wrong." · Headline/Medium · #566a7f
  ├── [ErrorBody]  — "Check your connection." · Body/Medium · #8592a3
  └── [RetryButton] — Button/Primary · Label: "RETRY" · Width: 140px
```

## 4.3 Delete Confirmation Dialog

Appears when user taps "Delete" from the 3-dot menu.

```
[DeleteDialog] — Frame · Absolute Position · Center of screen
  Width: 320px · Height: Hug
  Direction: Vertical · Padding: 24px · Gap: 16px
  Corner: 16px · Fill: #ffffff · Effects: shadow/bottomSheet

  ├── [DialogIcon] `delete_outline` · 32×32px · #ea5455
  ├── [DialogTitle] — "Delete City?" · Headline/Medium · #333333
  ├── [DialogBody]  — "This action cannot be undone." · Body/Medium · #8592a3
  └── [ButtonRow] — Frame · Horizontal · Fill · Gap: 12px
        ├── [CancelButton] — Outlined · Fill Container · #696cff
        │     "CANCEL" · Stroke 1.5px #696cff · Corner 8px · Height 44px
        └── [DeleteButton] — Filled · Fill Container · #ea5455
              "DELETE" · Fill #ea5455 · Corner 8px · Height 44px
```

---

---

# SECTION 5 — Figma File Structure (Recommended Page/Frame Organization)

Create the following **Pages** in your Figma file:

```
📄 Page 1: 00 — Design System
  ├── [Frame: Colors]      → All color tokens as colored rectangles with labels
  ├── [Frame: Typography]  → All text styles rendered as live text examples
  ├── [Frame: Spacing]     → Spacing tokens as labeled rectangles
  ├── [Frame: Shadows]     → Effect swatches (rectangles showing each shadow)
  └── [Frame: Components]  → All components from Section 2 with all variants

📄 Page 2: 01 — Flows (Prototype view)
  ├── [Frame: AuthFlow]       Splash → Login → Dashboard (connected with arrows)
  └── [Frame: MasterDataFlow] Dashboard → List → BottomSheet → Back

📄 Page 3: 02 — Screens
  ├── 01_Splash
  ├── 02_Login
  ├── 03_Dashboard
  ├── 04_City_List
  ├── 05_City_Add_BottomSheet
  ├── 06_NGO_List
  ├── 07_NGO_Add_Full
  ├── 08_Hospital_List
  ├── 09_Hospital_Add_Full
  ├── 10_Doctor_List
  ├── 11_Doctor_Add_Full
  ├── 12_Vehicle_List
  ├── 13_Vehicle_Add_Full
  └── 14_More_Screen

📄 Page 4: 03 — States
  ├── Shimmer/Loading states (all list screens)
  ├── Empty State template
  ├── Error State template
  ├── Delete Confirmation Dialog
  └── Snackbar (BG: #333333 · Text: white · Action: #696cff · Corner: 8px)

📄 Page 5: 04 — Handoff
  └── Annotated screens with dev notes, spacing callouts, and interaction annotations
```

---

---

# SECTION 6 — Prototype Interactions (Figma Prototype Panel)

| Trigger | From | To | Animation |
|---|---|---|---|
| Tap "SIGN IN" button | 02_Login | 03_Dashboard | Smart Animate · Slide Left · 300ms · Ease Out |
| Tap stat card | 03_Dashboard | 04_City_List | Smart Animate · Slide Left |
| Tap FAB (+) | 04_City_List | 05_City_Add_BottomSheet | Smart Animate · Slide Up · 350ms |
| Tap Scrim / drag handle | 05_City_Add_BottomSheet | 04_City_List | Smart Animate · Slide Down |
| Tap Back arrow | Any list screen | 03_Dashboard | Smart Animate · Slide Right |
| Tap "More" nav tab | 03_Dashboard | 14_More_Screen | Smart Animate · Slide Left |
| Tap "Hospitals" nav tab | Any screen | 08_Hospital_List | Instant |
| Tap Delete option (3-dot) | Any list card | Delete Dialog overlay | Smart Animate · Dissolve · 200ms |

---

---

# SECTION 7 — Developer Handoff Annotations

Add these as Figma annotations (sticky note frames) on the handoff page:

### Annotation 1 — Image Loading
> Coil image loading in all Avatar/Card images. If `image_url == null`, show placeholder.
> Placeholder BG: `#e7e7ff` · Icon: entity-specific · Color: `#696cff`

### Annotation 2 — Sticky Button Pattern
> All full-screen Add/Edit forms use a sticky bottom Save button.
> Footer container sits OUTSIDE the ScrollView in XML.
> Height: 76dp (52dp button + 12dp padding top + 12dp bottom = 76dp).

### Annotation 3 — Bottom Sheet Peek Height
> ModalBottomSheet peek height: full expanded (not half-screen).
> Drag handle is cosmetic — full dismiss on scrim tap or back press.

### Annotation 4 — Status Chips
> Chips are NOT buttons — they are display-only.
> Status toggling is done via the 3-dot PopupMenu → "Toggle Status" option.

### Annotation 5 — Form Validation
> Inline validation: show red border + helper text on field blur (focus lost).
> API errors (422): show helper text below respective field from `errors.field_name[0]`.
> Network errors: show Snackbar at bottom (BG: #333333 · 4s duration).

### Annotation 6 — RecyclerView Pull-to-Refresh
> All list screens support SwipeRefreshLayout.
> Refresh indicator color: `#696cff`.

---

*End of ABC Project Figma Auto-Layout Specification Document*
*Version 1.0 · April 2026 · Prepared for Goal Foundation Android UI/UX Handoff*