Symfony Translations Checker
============================

Symfony Translations Checker is a small PHP tool that checks the coherence of the translations of
a Symfony application across locales. It is designed to be used as a Continuous Integration tool.

It fails when it finds:

* domains that do not have the same locales as other domains
* keys that exists in the reference locale but not in another locale
* keys that exists in another locale but do not exist in the reference locale

It understands translations domains. For the moment, it only supports the YAML format.

> **Note:** This tool isn't an official Symfony tool. I developed it for my own needs and thought
> it could be useful to others, thus I open-sourced it. I plan to maintain it in the long term,
> so feel free to use it whever you wish.

# Usage

Symfony Translations Checker is a PHAR file that you can download (on the releases page) and execute, 
pointing it to your translations directory:

```bash
php symfony-translation-checker.phar check /path/to/your/project/translations
```

By default, the locale acting as reference is either English or the first one found.
You can change this setting by passing a reference option:

```bash
php symfony-translation-checker.phar check /path/to/your/project/translations --reference=fr
```
