# Skill: Drupal Backend & Persistence
- **PHP Moderno:** Usar siempre PHP 8.1+ con tipos estrictos. Inyectar dependencias vía constructor (prohibido `\Drupal::service`).
- **SQL Standars:** - No usar `SELECT *`. Listar campos específicos.
    - Usar placeholders con nombre `:name` (no `%d` o `%s`).
    - Las tablas se citan con `{tabla}` y los campos con `[columna]`.
    - Seguir la lista de palabras reservadas SQL (Keywords) para nombres de tablas.
- **Spelling:** - Usar inglés US.
    - Si el código no es inglés (tokens/hashes), usar `// cspell:disable-next-line`.
- **Excepciones:** Terminar siempre en `Exception` y no traducir el mensaje de error.