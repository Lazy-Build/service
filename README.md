## What?

This project is for ease of use and won't work for everything.

The goal is to easily provide setup scripts for users. 

All scripts should be publicly available.

The ideal use case being 

```bash
curl https://lazy.build/google-chrome?distro=arch | bash
curl https://lazy.build/google-chrome?distro=deb/debian | bash
curl https://lazy.build/some/pattern?arch=x86 | bash
curl https://lazy.build/some/pattern?arch=x86_64 | bash
```

## Setting up yourself

```bash
git clone --recurse-submodules git@github.com:Lazy-Build/service.git
docker run --rm -v "$(pwd)":/opt -w /opt laravelsail/php80-composer:latest bash -c "composer install"
vendor/bin/sail up -d

vendor/bin/sail artisan update-scripts

```
