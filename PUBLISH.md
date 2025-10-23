# Publishing aiods/core to Packagist

## Prerequisites

1. **Create a Packagist account** (if you don't have one)
   - Go to https://packagist.org/register
   - Verify your email

2. **Set up GitHub repository** (recommended)
   - Create a repository on GitHub
   - Push your code to GitHub

## Publishing Steps

### 1. Prepare the Package

```bash
cd packages/aiods/core
```

### 2. Update Version

Update the version in `composer.json`:
```json
{
  "version": "1.0.0"
}
```

### 3. Create Git Repository

```bash
# Initialize git if not already done
git init

# Add files
git add .

# Commit
git commit -m "Initial release v1.0.0"

# Create tag
git tag v1.0.0
```

### 4. Push to GitHub

```bash
# Add remote (replace with your GitHub URL)
git remote add origin https://github.com/yourusername/aiods-core.git

# Push code and tags
git push -u origin main
git push --tags
```

### 5. Submit to Packagist

1. Go to https://packagist.org/packages/submit
2. Enter your GitHub repository URL: `https://github.com/yourusername/aiods-core`
3. Click "Check" then "Submit"

### 6. Set up GitHub Hook (Auto-update)

After submitting, Packagist will show you a webhook URL:
1. Go to your GitHub repository Settings > Webhooks
2. Add webhook with the Packagist URL
3. This will auto-update Packagist when you push changes

## Version Management

### Semantic Versioning

- **Patch** (1.0.1): Bug fixes
- **Minor** (1.1.0): New features, backward compatible
- **Major** (2.0.0): Breaking changes

### Update Version

```bash
# Update version in composer.json
git add composer.json
git commit -m "Bump version to 1.0.1"
git tag v1.0.1
git push origin main --tags
```

Packagist will auto-update via webhook.

## After Publishing

### Install in Other Projects

```bash
composer require aiods/core
```

Or in `composer.json`:
```json
{
  "require": {
    "aiods/core": "^1.0"
  }
}
```

## Publishing Checklist

- [ ] Complete `composer.json` with all required fields
- [ ] Create GitHub repository
- [ ] Push code to GitHub
- [ ] Create initial git tag
- [ ] Submit to Packagist
- [ ] Set up GitHub webhook
- [ ] Verify package appears on Packagist

## Package Structure Required

Your package should have:
- ✅ `composer.json` with correct metadata
- ✅ `src/` directory with PHP classes
- ✅ README.md
- ✅ Proper namespaces (`Aiods\Core\`)

## Local Development Before Publishing

You can use it locally first:

```json
// In your main composer.json
{
    "repositories": [
        {
            "type": "path",
            "url": "./packages/aiods/core"
        }
    ],
    "require": {
        "aiods/core": "*"
    }
}
```

```bash
composer update
```

## Finding Your Package

After publishing, it will be available at:
- https://packagist.org/packages/aiods/core
- Install with: `composer require aiods/core`

## Troubleshooting

### "Package name already exists"
- Change the package name in `composer.json`
- Use a different namespace

### "Invalid composer.json"
- Validate with: `composer validate`
- Fix any errors shown

### Package not updating
- Check webhook setup
- Manually trigger update: https://packagist.org/packages/aiods/core?action=update

