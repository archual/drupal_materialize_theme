<!-- @file Instructions for subtheming using the LESS Starterkit. -->
<!-- @defgroup subtheme_less -->
<!-- @ingroup subtheme -->
# LESS Starterkit

Below are instructions on how to create a Materialize sub-theme using a LESS
preprocessor.

- [Prerequisites](#prerequisites)
- [Additional Setup](#setup)
- [Override Styles](#styles)
- [Override Settings](#settings)
- [Override Templates and Theme Functions](#registry)

## Prerequisites
- Read the @link getting_started Getting Started @endlink documentation topic.
- You must understand the basic concept of using the [LESS] CSS pre-processor.
- You must use a **[local LESS compiler](https://www.google.com/search?q=less+compiler)**.
- You must use the [Materialize Framework Source Files] ending in the `.less`
  extension, not files ending in `.css`.

## Additional Setup {#setup}
Download and extract the **latest** 3.x.x version of
[Materialize Framework Source Files] into your new sub-theme. After it has been
extracted, the folder should read `./subtheme/materialize`.

If for whatever reason you have an additional `materialize` folder wrapping the
first `materialize` folder (e.g. `./subtheme/materialize/materialize`), remove the
wrapping `materialize` folder. You will only ever need to touch these files if
or when you upgrade your version of the [Materialize Framework].

{.alert.alert-warning} **WARNING:** Do not modify the files inside of
`./subtheme/materialize` directly. Doing so may cause issues when upgrading the
[Materialize Framework] in the future.

## Override Styles {#styles}
The `./subtheme/less/variable-overrides.less` file is generally where you will
the majority of your time overriding the variables provided by the [Materialize
Framework].

The `./subtheme/less/materialize.less` file is nearly an exact copy from the
[Materialize Framework Source Files]. The only difference is that it injects the
`variable-overrides.less` file directly after it has imported the[Materialize
Framework]'s `variables.less` file. This allows you to easily override variables
without having to constantly keep up with newer or missing variables during an
upgrade.

The `./subtheme/less/overrides.less` file contains various Drupal overrides to
properly integrate with the [Materialize Framework]. It may contain a few
enhancements, feel free to edit this file as you see fit.

The `./subtheme/less/style.less` file is the glue that combines the
`materialize.less` and `overrides.less` files together. Generally, you will not
need to modify this file unless you need to add or remove files to be imported.
This is the file that you should compile to `./subtheme/css/styles.css` (note
the same file name, using a different extension of course).

## Override Theme Settings {#settings}
Please refer to the @link subtheme_settings Sub-theme Settings @endlink topic.

## Override Templates and Theme Functions {#registry}
Please refer to the @link registry Theme Registry @endlink topic.

[Materialize Framework]: http://materializecss.com/
[Materialize Framework Source Files]: https://github.com/dogfalo/materialize/
[LESS]: http://lesscss.org
