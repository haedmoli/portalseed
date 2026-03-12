# Manifesto — Librería Canvas (Guía de Creación)

Este documento es una especificación de diseño. Cada sitio nuevo crea sus propios SDC desde cero siguiendo estas recetas. No es una dependencia de módulo, es un estándar.

---

## Stack de Estilos: Tailwind CSS (obligatorio)

**Tailwind CSS es el sistema de estilos base requerido** para todos los componentes de esta librería. Cualquier tema que implemente estos componentes debe tenerlo instalado y compilado.

**Setup mínimo requerido en el tema:**
```json
// package.json
{
  "scripts": {
    "build": "tailwindcss -i ./src/css/styles.css -o ./dist/css/styles.css --minify",
    "watch": "tailwindcss -i ./src/css/styles.css -o ./dist/css/styles.css --watch"
  },
  "devDependencies": { "tailwindcss": "^3.4" }
}
```
```js
// tailwind.config.js — incluir las rutas de templates y componentes
module.exports = {
  content: ['./templates/**/*.twig', './components/**/*.twig'],
  theme: { extend: {} },
}
```
```css
/* src/css/styles.css */
@tailwind base;
@tailwind components;
@tailwind utilities;
```

**Convención CSS en componentes:**
- Usar `@apply` de Tailwind **para layout y utilidades** (flex, grid, padding, responsive).
- Usar **CSS custom properties** (`--token-color`, `--token-size`) para valores de marca/diseño.
- **Nunca** usar colores hex directos en el CSS del componente.
- El CSS compilado vive en `dist/css/styles.css` y se referencia desde `[theme].libraries.yml`.

---

## Reglas Base (todos los componentes)

- El archivo `[name].component.yml` debe tener un `title` por prop para que Canvas genere su UI automáticamente.
- **Mapeo de Fechas**: Usar `type: string` + `format: date` para que Canvas ofrezca el campo "Authored on".
- **Props Avanzados (Imágenes/Video/Links):** Consultar `../external/canvas-react-skills/canvas-component-metadata/SKILL.md` para ver el uso avanzado de `$ref` (ej: `json-schema-definitions://canvas.module/image`).
- **Slots:** Los slots deben ser declarados como un mapa de objetos indexado por nombre, o como `[]` si el componente no utiliza slots. (Ver `canvas-component-metadata/SKILL.md` para más detalles).
- Usar `enum` + `meta:enum` para campos de opción (nunca strings libres en select).
- Siempre incluir `''` (string vacío) en los `enum` opcionales para evitar errores de validación cuando Canvas no pasa valor.
- El `[name].css` usa `@apply` de Tailwind + variables (`--token-valor`) y **nunca** usa `height: 100vh` absoluto. Usar `clamp(min, 90vh, 1080px)` para compatibilidad con el iframe del editor Canvas.
- El `[name].twig` **debe** usar `{{ attributes }}` para que Canvas pueda inyectar metadata de edición.
- **SVGs Inline**: Siempre definir `width` y `height` en el tag `<svg>` para garantizar visibilidad en el editor de Canvas.

---


## Átomos (Componentes Base)

**Button** — Botón estándar.
Props: `text` (string, required), `url` (string), `style` (enum: primary|secondary|ghost).

**Icon** — Icono SVG inline.
Props: `name` (string, required), `size` (enum: sm|md|lg), `color` (string).

**Heading** — Título semántico configurable.
Props: `text` (string, required), `level` (enum: h1|h2|h3|h4), `style` (enum: display|title|subtitle).

---

## Moléculas (Componentes Funcionales)

**Card** — Contenedor de contenido. Reutiliza **Button** y **Heading** con `{% include %}`.
Props: `title` (string, required), `description` (string), `image_url` (string), `cta_text` (string), `cta_url` (string).

**Input Field** — Campo de formulario estilizado.
Props: `label` (string, required), `placeholder` (string), `type` (enum: text|email|tel), `name` (string, required).

**Social Share** — Disparador de redes sociales con popover.
Props: `url` (string|null), `title` (string|null).
Diseño: Requiere un trigger SVG y un contenedor absoluto `.is-visible` con iconos de marca (Facebook, X, LinkedIn, Instagram).

---

## Organismos (Secciones Completas)

### Hero — Sección principal con video de fondo.
Reutiliza: **Heading**.
Props:
- `heading` (string) — Título principal.
- `text` (string|null) — Subtítulo o descripción.
- `video_url` (string|null) — URL del video de fondo (.webm/.mp4).
- `effect` (enum: ''|none|glass-effect|glass-navbar, default: none) — Efecto de cristal.
- `animation` (enum: ''|none|pulse-glow|float-gentle, default: none) — Animación de entrada.

Patrón CSS clave:
```css
.hero {
  min-height: clamp(400px, 90vh, 1080px);
  position: relative;
  overflow: hidden;
}
```

### Hero Article — Hero de portada para artículos.
Props:
- `heading` (string, **required**) — Título del artículo (H1).
- `subheading` (string|null) — Resumen/bajada.
- `image_url` (string|null) — URL absoluta de la imagen de fondo.
- `image_alt` (string|null) — Alt text para accesibilidad.
- `cta_text` (string|null) — Texto del botón CTA.
- `cta_url` (string|null) — Destino del CTA.
- `tags` (array of string|null) — Etiquetas/categorías.
- `overlay_style` (enum: ''|none|dark|gradient, default: gradient) — Tipo de overlay sobre imagen.

Patrón CSS clave:
```css
.hero-article {
  --ha-min-height: clamp(400px, 90vh, 1080px);
  position: relative;
  min-height: var(--ha-min-height);
  isolation: isolate;
}
```

### Navbar — Barra de navegación.
Reutiliza: **Button**.
Props: `logo_url` (string), `logo_alt` (string), `links` (array: {text, url}), `cta_text` (string), `cta_url` (string).

---

## Notas de Activación en Canvas

Para registrar cualquier componente de esta librería en el Content Type de destino, agregar en `field.field.node.[tipo].field_canvas.yml`:

```yaml
third_party_settings:
  canvas:
    allowed_components:
      - 'sdc.[theme_o_module]:[component-name]'
```

El ID del SDC siempre sigue el patrón: `[proveedor]:[nombre-carpeta-componente]`.