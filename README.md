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


## Screenshot
<img src="https://github.com/plenta/contao-countup-bundle/blob/master/docs/img/contao-element.png?raw=true" width="700" alt="Contao-Element">
