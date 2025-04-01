# Contao Count Up Bundle

This Contao content element counts up numbers.  
This plugin is based on and utilizes [CountUp.js](https://github.com/inorganik/CountUp.js)

CSS files are not included (coming soon).

## Install using Composer

```bash
composer require plenta/contao-countup-bundle
```

### Which version is right for you?

| Contao Version | PHP Version | Contao Count Up Bundle Version |
|----------------|-------------|--------------|
| 4.9.*          | \>= 7.4     | 2.*          |
| 4.13.*         | \>= 7.4     | 2.*          |
| 5.*            | \>= 8.3     | 3.*          |


## Usage
Simply add the Contao element to your page.  
The Contao element accepts the following arguments:

- Start value: number to begin the counter from
- Count up value: number to end the counter at
- Animation duration: time in seconds
- Prefix: text at the beginning the value
- Suffix: text added at the end of the value
- Number grouping: enable grouping of numbers (1,000 vs 1000)
- Decimal places are calculated automatically

### Using Insert Tags
You can use insert tags to set the start and end values, but there are some rules:
- The decimal point must be a `.` (dot) and the thousands separator must be a `,` (comma).
- Both numbers must have the same format. For example, if one number has two decimal places, the other must also have two decimal places.
- Only numbers are allowed.
- The backend input fields can either accept numbers or insert tags, but not both in the same field.



## Screenshot
<img src="https://github.com/plenta/contao-countup-bundle/blob/master/docs/img/contao-element.png?raw=true" width="700" alt="Contao-Element">
