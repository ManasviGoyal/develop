# HydePHP - Static Blog Builder using Laravel Zero

> This repo both contains the source code and serves as a template to get started quickly.

HydePHP is a Static Site Builder focused on making Blog posts easy and fun. Under the hood it is powered by Laravel Zero which is a stripped down version of the robust Laravel Framework. Using Blade templates the site is intelligently compiled into static HTML. Content is created using Markdown, which supports YAML Front Matter.

Hyde is inspired by JekyllRB and is created for Developers who are comfortable writing posts in Markdown. It requires virtually no configuration out of the box as it favours convention over configuration. Though you can easily modify settings in the config/hyde.php to personalize your site. You can also directly modify the Blade views to make it truly yours.

The frontend uses a lightweight minimalist layout build with TailwindCSS which you can extend with the Blade components.

Hyde is designed to be stupidly simple to get started with, while also remaining easily hackable and extendable.

## Installation
The reccomended method of installation is using Composer. However, if you want to run the latest development version you can clone the Git repo.

### Using Composer (reccomended)
```bash
composer create-project hyde/hyde
```

### Using Git

#### Using the website
Navigate to https://github.com/hydephp/hyde and press the green button with the text "Use this template" and follow the instructions.

Remember to run `composer install` and `npm install && npm run dev`

#### Using CLI
```bash
git clone https://github.com/hydephp/hyde.git
cd hyde
composer install
npm install && npm run dev
```

### Requirements 
> These requirements are for your local development environment. The static HTML can be hosted virtually anywhere, including on GitHub Pages.
Hyde uses Laravel 9 which requires PHP >= 8.0. You should also have Composer and NPM installed.


## Getting Started
It's a breeze to get started. Simply clone the repository, write your Markdown posts and save them to the _posts directory and run the `php hyde build` command. You can scaffold post files using the `php hyde make:post` command.



### Usage


#### Writing posts
Posts are written in Markdown and saved in the _posts directory. Save your file as `kebab-case-slug.md`.
Post metadata is added as YAML Front Matter
```yaml
---
title: My New Post
description: A short description used in previews and SEO
category: blog
author: Mr. Hyde
date: 2022-03-14 15:00
---

# Write your Markdown here
```

> You can also create simple static pages by creating Markdown files in the _pages directory.

> You can even create pages with full Blade support by creating files ending in .blade.php in the resources/views/pages directory.

#### Building the static site

Then to compile the site into static HTML all you have to do is execute the Hyde build command.
```bash
php hyde build
```

Your site will then be saved in the _site directory, which you can then upload to your static web host.
All links use relative paths, so you can deploy to a subdirectory without problem.
The site also works great when browsing the HTML files locally.

If it is the first time building the site or if you have updated the source SCSS you also need to run `npm install && npm run dev`.

> `npm run dev` and `npm run prod` both first build the static site and compiles the styles. The latter command also minifies the CSS.

#### Live preview
Use `npm install && npm run watch` to watch the files for changes and start up a local dev server on port 3000 using Browsersync.


### NPM Commands
To help in development the `package.json` comes with a few built in scripts. Make sure you have Node and NPM installed.
> If it is the first time running a command, remember to run `npm install` first!

The main commands are:
- `npm run dev`
- `npm run prod`
- `npm run watch`

#### Dev: Build the site for development
Runs the `php hyde build` command, compiles the SASS and Tailwind

#### Prod: Build the site for production
Runs the `php hyde build` command, compiles the SASS and Tailwind and minifies the output.

#### Watch: Watching files for changes

Hyde has a realtime compiler that watches your files for changes and rebuilds the site on the fly.
> Currently, all pages are rebuilt, but in a future update only the affected files will be rebuilt.

The realtime viewer also uses Browsersync which starts a local web server and automatically refreshes your pages once they are changed. 

**To start the preview run**
```bash
npm run watch
```
A browser page should automatically be opened. If not, just navigate to http://localhost:3000/.


### Hacking Hyde
Hyde is designed to be easy to use and easy to hack. You can modify the source views and SCSS, customize the Tailwind config, and you can even create 100% custom HTML and Blade pages that get compiled into static HTML.

## Why static sites?
### Speed, scalability, simplicity
With a static site you don't need to worry about setting up databases.
This makes the site so much faster as you don't need to wait for a database to process requests.
By pre-compiling the sites you also don't need to waste time and processing power on server-side
rendering which also speeds up your site. Furthermore, it makes your site incredibly scalable
as you don't need to worry about keeping replica databases in sync.

You can even serve the site from global CDNs on the Edge for amazing speed.

### Security, stability, and cost
You don't need to worry about keeping your database secure since there is no database.
You can also rest easy knowing your site is stable and that you don't need to maintain
a complex backend.

You can also use create a Git powered CMS to collaborate on Markdown posts.

Static web hosting has become incredibly cheap, to the point where dozens of companies offer
free hosting.

## Extensions
Hyde comes with build in support for Torchlight Syntax Highlighting.
All you need to do is to set your API token in your .env file and
Hyde will automatically enable the CommonMark extension.

> Note that when using Torchlight the pages will take longer to generate as API calls needs to be made.
> However, Torchlight caches the response so this only affects the first time running the build, or 
> if you update the page.

## Known Issues
Deleting Markdown posts does not delete the already compiled HTML files.
In a future update (coming soon(tm)) the builder will remove unused files automatically.
For now, you can manually delete the files and then run the build command.

Currently, only top level custom pages are supported. In the future nested pages will be supported.
For example, _site/directory/page.html

Hyde also currently does not support images, but will soon as it already has the foundation in place to do so.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email caen@desilva.se instead of using the issue tracker.
All vulnerabilities will be promptly addressed.

## Credits

-   [Caen De Silva](https://github.com/caendesilva)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Attributions
> Please see the respective authors' repositories for their license files

- The Hyde core is built with [Laravel Zero](https://laravel-zero.com/) which is based on (Laravel)[https://laravel.com/]
- The frontend is built with [TailwindCSS](https://tailwindcss.com/) with components from [Flowbite](https://flowbite.com/docs/customize/dark-mode/).
- The default favicon was created using [Favicon.io](https://favicon.io/) using an icon from the amazing open-source project [Twemoji](https://twemoji.twitter.com/). The graphics are copyright 2020 Twitter, Inc and other contributors and are licensed under [CC-BY 4.0](https://creativecommons.org/licenses/by/4.0/).
