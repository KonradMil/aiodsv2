# How to Publish PHP Package to Packagist

## Current Status

✅ Package structure created at: `packages/aiods/core/`
✅ Composer.json configured
✅ Source files ready

## Publishing Steps

### 1. Initialize Git Repository

```bash
cd packages/aiods/core
git init
git add .
git commit -m "Initial release"
```

### 2. Create GitHub Repository

Create a new repository on GitHub called `aiods-core`:

```bash
# Using GitHub CLI (if installed)
gh repo create aiods-core --public --source=. --push

# OR manually:
# 1. Create repo on GitHub.com
# 2. Then run:
git remote add origin https://github.com/YOUR_USERNAME/aiods-core.git
git push -u origin main
```

### 3. Create Version Tag

```bash
git tag v1.0.0
git push --tags
```

### 4. Submit to Packagist

1. Go to: https://packagist.org/packages/submit
2. Enter your GitHub URL: `https://github.com/YOUR_USERNAME/aiods-core`
3. Click "Check" then "Submit"

### 5. Set Up Auto-Update

After submitting:
1. Go to your Packagist package page
2. Click "Settings" > "GitHub"
3. Copy the webhook URL
4. Add it to your GitHub repo: Settings > Webhooks > Add webhook

## After Publishing

### Install in Other Projects

```bash
composer require aiods/core
```

### Your Package Will Be Available At

- https://packagist.org/packages/aiods/core
- Install with: `composer require aiods/core`

## Updating Versions

```bash
# Update version in composer.json
git add composer.json
git commit -m "Bump to v1.0.1"
git tag v1.0.1
git push origin main --tags
```

Packagist will auto-update via webhook.

## What Gets Published

- ✅ `composer.json` - Package metadata
- ✅ `src/` - All PHP source files
- ✅ `README.md` - Documentation
- 📦 Total: ~500KB

## Quick Commands

```bash
# Full publish workflow
cd packages/aiods/core
git init && git add . && git commit -m "Initial release"
git tag v1.0.0
# Push to GitHub (create repo first)
git push origin main --tags
# Submit to Packagist
# Visit: https://packagist.org/packages/submit
```

See `PUBLISH.md` for detailed instructions.

