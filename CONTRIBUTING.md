# Contributing

This repository is a focused WordPress/WooCommerce theme portfolio. Changes should be small, reviewable, and reproducible from public source.

## Git workflow

1. Open or reference an issue with scope and acceptance criteria.
2. Branch from `main` using `feat/`, `fix/`, `refactor/`, `perf/`, `ci/`, `docs/`, or `chore/`.
3. Keep commits atomic and use clear Conventional Commit-style subjects.
4. Open a pull request that explains implementation choices, UI/accessibility impact, performance impact, and validation.
5. Merge only after PHP and frontend CI checks pass.

## Local checks

```bash
npm install
npm run lint:js
npm run build
find . -type f -name '*.php' -print0 | xargs -0 -n1 php -l
```

## Theme expectations

- Use WordPress escaping functions at output boundaries.
- Sanitize/validate external input before use.
- Keep templates accessible by default: semantic landmarks, keyboard access, visible focus, useful labels, and valid heading structure.
- Use WordPress enqueue APIs for frontend assets.
- Avoid duplicate SEO/schema output when a dedicated SEO plugin already owns it.
- Keep performance work scoped so commerce/account flows retain required WooCommerce assets.
- Never commit credentials, customer data, database exports, uploads, logs, or production-only configuration.
