# HydePHP - Static App Builder powered by Laravel

<p>
    <a href="https://packagist.org/packages/hyde/hyde"><img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/packagist/v/hyde/hyde" alt="Latest Version on Packagist"></a>
    <a href="https://packagist.org/packages/hyde/framework"><img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/packagist/dt/hyde/framework" alt="Total Downloads"></a>
    <a href="https://github.com/hydephp/hyde/blob/master/LICENSE.md"><img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/github/license/hydephp/hyde" alt="License"></a>
    <img style="display: inline; margin: 4px 2px;" src="https://cdn.desilva.se/microservices/coverbadges/badges/9b8f6a9a7a48a2df54e6751790bad8bd910015301e379f334d6ec74c4c3806d1.svg" alt="Test Coverage" title="Average coverage between categories">
    <img style="display: inline; margin: 4px 2px;" src="https://github.com/hydephp/hyde/actions/workflows/tests.yml/badge.svg" alt="GitHub Actions">
    <img style="display: inline; margin: 4px 2px;" src="https://github.com/hydephp/hyde/actions/workflows/codeql-analysis.yml/badge.svg" alt="GitHub Actions">
    <a href="https://github.styleci.io/repos/472503421?branch=master"><img style="display: inline; margin: 4px 2px;" src="https://github.styleci.io/repos/472503421/shield?branch=master" alt="StyleCI"></a>
</p>

## Make static websites, blogs, and documentation pages with the tools you already know and love.
---

## ⚠ Beta Software Warning ⚠
### Heads up! HydePHP is still very new. As such there may be bugs (please report them) and breaking changes.
#### Please wait until v1.0 for production use and remember to backup your source files before updating (use Git!).
---

HydePHP is a new Static Site Builder focused on writing content, not markup. With Hyde, it is easy to create static websites, blogs, and documentation pages using Markdown and (optionally) Blade.

Hyde is powered by Laravel Zero which is a stripped-down version of the robust Laravel Framework. Using Blade templates the site is intelligently compiled into static HTML.

Hyde is inspired by JekyllRB and is created for Developers who are comfortable writing posts in Markdown. It requires virtually no configuration out of the box as it favours convention over configuration. This is what makes Hyde different from other Laravel static site builders that are more focused on writing your blade views from scratch, which you can do with Hyde too if you want.

Hyde is designed to be stupidly simple to get started with, while also remaining easily hackable and extendable.
Hyde comes with a lightweight minimalist frontend layout built with TailwindCSS which you can extend and customize with the Blade components.

Due to this powerful modularity yet elegant simplicity, Hyde is a great choice for developers no matter what their background or experience level.
Here are some ideas for what you can do with Hyde:
- You are a Laravel developer and want to build a static site without having to learn a new framework. Why not use Hyde, and take advantage of the built-in Blade support?
- You just want to write blog posts in Markdown and not have to worry about anything else. Give Hyde a try and see if it helps you out.
- You want to get a documentation site up and running quickly, allowing you to focus on content.

## Live Demo
The Hyde site (https://hydephp.github.io/docs/) is fully built with Hyde. That includes the homepage, the blog, and the [documentation](https://hydephp.github.io/docs/docs/index.html)!

## Installation
> Full installation guide is in the documentation at https://hydephp.github.io/docs/

The recommended method of installation is using Composer. You should have PHP >= 8.0 installed.

```bash
composer create-project hyde/hyde --stability=dev
```

> Hyde uses Laravel 9 which requires PHP >= 8.0. You should also have Composer and NPM installed. The static HTML can be hosted virtually anywhere, including on GitHub Pages.

## Getting Started
### High-level overview
It's a breeze to get started. After creating a new Hyde project, place markdown files in the content directories, run the build command, and you're ready to upload your site to your host, or GitHub Pages.

### Writing content
Hyde has two ways to write content. First, we have Markdown, which is easy to write and easy to read. Secondly, we have Blade templates, which are more powerful and give you full control over the HTML. Blade pages can also be used to write content more dynamically.

To write content in Markdown, simply place your files in the appropriate content directories (prefixed with an `_underscore`).

For example, if you want to write a blog post, place it in the `_posts/` directory. If you want to write a page, place it in the `_pages/` directory. If you want to write a documentation page, place it in the `_docs/` directory.

To make a Blade page, place your file in the `_pages/` directory. If you take a look here, you will see that there is a file named `index.blade.php`. This is the default welcome page. You can replace it with any of the other built-in index pages using the `php hyde publish:homepage` command.

When compiling the site, the files in the content directories will be compiled into the appropriate subdirectories within the output directory `_site/`.

#### A note on filenames
Hyde uses the `.md` extension for Markdown files and the `.blade.php` extension for Blade files. When compiling, the files will keep their base filenames, but with the extension renamed to `.html`. For example, the file `_posts/my-post.md` will be compiled to `_site/posts/my-post.html`.

### HydeCLI and compiling your site
The main way to interact with Hyde, besides writing Markdown content, is to use the Hyde CLI. If you are coming from Laravel and have experience using Artisan you will feel right at home.

See the [console command docs](https://hydephp.github.io/docs/master/console-commands.html) for the full guide.

Compile the static site using the `hyde build` command.
```bash
// Compile the static site
php hyde build

// Or, compile a single file
php hyde rebuild _posts/example.md
```

You can scaffold files using the `hyde make` command.
```bash
// Create a new post
php hyde make:post

// Create a new page
php hyde make:page "Page Title" [--type="markdown/blade"]
```

### NPM Commands

There are also a few NPM commands that can be used to build the frontend, please see the [console command docs](https://hydephp.github.io/docs/master/console-commands.html) for more information.

#### Live preview
Use `npm run watch` to watch the files for changes and start up a local dev server on port 3000 using Browsersync.


### How it works
Hyde scans the source directories prefixed with _underscores for Markdown files and intelligently compiles them into static HTML using Blade templates. The site is then saved in _site.

Hyde is "blog and documentation aware" and has built-in templates for both blogging and for creating beautiful documentation pages based on Laradocgen. Since Hyde is modular you can of course disable the modules you don't need. You can of course also write your own views.

The full usage guide is in the documentation at https://hydephp.github.io/docs/

## Hacking Hyde
Hyde is designed to be easy to use and easy to customize and hack. You can modify the source views and SCSS, customize the Tailwind config, and you can even create 100% custom HTML and Blade pages that get compiled into static HTML.

While Hyde favours "convention over configuration" there are a few config options in the `config/hyde.php` file. All settings are prefilled with sensible defaults so you don't need to configure anything unless you want to!

## Extensions
Hyde comes with built-in support for Torchlight Syntax Highlighting.
All you need to do is to set your API token in your .env file and
Hyde will automatically enable the CommonMark extension.

> Note that when using Torchlight the pages will take longer to generate as API calls need to be made.
> However, Torchlight caches the response so this only affects the first time running the build, or if you update the page.

## Known Issues
Hyde does not automatically delete compiled HTML files when the source files have been removed. 
However, you can supply the `--clean` flag to remove all content in the `_site` directory when running the build command.

Currently, only top-level custom pages are supported. In the future, nested pages will be supported.
For example, _site/directory/page.html

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

- The Hyde core is built with [Laravel Zero](https://laravel-zero.com/) which is based on [Laravel](https://laravel.com/)
- The frontend is built with [TailwindCSS](https://tailwindcss.com/).
