# Agent Instructions

## Docker-first Node workflow

- Do not run `npm`, `npx`, `node`, or other Node.js tooling directly on the host machine.
- Run all Node.js and frontend package manager commands inside the Docker app container.
- For this repository, use the `laravel.test` service from `docker-compose.yml`.

## Required command pattern

- Use `docker compose exec laravel.test npm ...` for package installation, builds, and scripts.
- Use `docker compose exec laravel.test node ...` for direct Node.js execution.
- If the container is not running, start it before executing Node-related commands.

## Examples

- `docker compose exec laravel.test npm install`
- `docker compose exec laravel.test npm run build`
- `docker compose exec laravel.test node -v`

