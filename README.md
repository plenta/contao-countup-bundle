# Contao Count Up Bundle

This Contao content element counts up numbers.  
This plugin is based on and uses [CountUp.js](https://github.com/inorganik/CountUp.js).

CSS files are not included (coming soon).

## Install using Composer

```bash
composer require plenta/contao-countup-bundle
```

### Which version is right for you?

| Contao Version | PHP Version | Contao Count Up Bundle Version |
|----------------|-------------|--------------------------------|
| 4.9.*          | \>= 7.4     | 2.2.1                          |
| 4.13.*         | \>= 7.4     | 2.3.*                          |
| \>= 5.3.0      | \>= 8.3     | \>= 3.0.0                      |


## Usage
To use this, simply add the Contao element to your page.
The Contao element accepts the following options:

- Start value: The number where the counter begins.
- Count up value: The number where the counter ends.
- Animation duration: The time (in seconds) for the animation to complete.
- Prefix: Text added before the number.
- Suffix: Text added after the number.
- Number grouping: Enable grouping for large numbers (e.g., 1,000 instead of 1000).
- Decimal places: Decimal places are automatically calculated.

### Using Insert Tags
You can use insert tags to set the start and end values, but there are some rules:
- The decimal point must be a `.` (dot) and the thousands separator must be a `,` (comma).
- Both numbers must have the same format. For example, if one number has two decimal places, the other must also have two decimal places.
- Only numbers are allowed.
- The backend input fields can either accept numbers or insert tags, but not both in the same field.

## Upgrade 2.* to 3.0.0
### Templates 
- **Old template name**: `ce_plenta_countup.html5`
- **New template name**: `content_element/plenta_countup.html.twig`

### CSS Classes
| Old            | New                  |
|----------------|----------------------|
| .ce_plenta_countup | .content-plenta-countup |
| .countUpPrefix | .countup-prefix      |
| .countUpValue  | .countup-value       |
| .countUpSuffix | .countup-suffix      |


### JavaScript Location Changed
The JavaScript for the countup bundle has been moved. It is now inside the `block script` section of the new twig template. Previously, the JavaScript was added to the `$GLOBALS['TL_BODY']` in the `getResponse` method of the content element controller.

## Screenshot
<img src="https://github.com/plenta/contao-countup-bundle/blob/main/docs/img/contao-element.png?raw=true" width="700" alt="Contao-Element">
