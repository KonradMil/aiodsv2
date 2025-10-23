# Quick Publish Guide for PHP Package

## Steps to Publish aiods/core to Packagist

### 1. Create GitHub Repository

```bash
cd packages/aiods/core

# Initialize git
git init
git add .
git commit -m "Initial release"

# Create GitHub repo and push
gh repo create aiods-core --public --source=. --push
```

### 2. Create Version Tag

```bash
git tag v1.0.0
git push --tags
```

### 3. Submit to Packagist

1. Go to: https://packagist.org/packages/submit
2. Enter your GitHub URL: `https://github.com/yourusername/aiods-core`
3. Click "Check" then "Submit"

### 4. Set Up Auto-Update

- Go to your Packagist package page
- Click "Settings" > "GitHub"
- Copy the webhook URL
- Add it to your GitHub repo webhooks

## That's It!

Your package will be available at:
- https://packagist.org/packages/aiods/core

Install with:
```bash
composer require aiods/core
```

## Next Version

```bash
# Update version in composer.json
git add composer.json
git commit -m "Bump to v1.0.1"
git tag v1.0.1
git push origin main --tags
```

Packagist will auto-update via webhook.

