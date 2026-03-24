# Skill: Twig & YAML Architecture
- **Twig Coding:** - Seguir estándares de Symfony/Twig.
    - Docblocks arriba con `{# /** ... */ #}` incluyendo `@file` y variables disponibles.
    - Usar filtros en lugar de funciones cuando sea posible (`{{ 'text'|t }}`).
    - Atributos: Usar siempre `{{ attributes.addClass('clase') }}`.
- **YAML Config:**
    - Indentación obligatoria de 2 espacios.
    - Los nombres de archivo deben empezar por el machine_name del módulo.
    - Límite de 250 caracteres para nombres de configuración.