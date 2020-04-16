# Contao Company Bundle
Allows you to manage company details for one or more companies provided in settings and root pages. Company details stored in settings are used as fallback, if an specific company detail is missing in involved root page.

You can display company details dynamically simply by using the provided company modules or alternatively by using a company insert tag. 

## Overview
The following company details can be stored in settings and root pages:

- `Logo`
- `Company name`
- `Street`
- `Postal code`
- `City`
- `State`
- `Country`
- `Phone number`
- `Phone number 2`
- `Fax number`
- `E-mail address`
- `Social-Media links`

## Modules
The following frontend modules are provided:

- `Logo`: Displays the stored company logo
- `Social media list`: Displays stored social media links

## Insert tags
All company details can be called anywhere by the following insert tags:

- `{{company::name}}`
- `{{company::street}}`
- `{{company::postal}}`
- `{{company::city}}`
- `{{company::state}}`
- `{{company::country}}`
- `{{company::phone}}`
- `{{company::phone2}}`
- `{{company::fax}}`
- `{{company::email}}`

### Additional insert tags:

- `{{company::mailto}}`: Outputs a mailto link e.g. `<a href="mailto:my@mail.de">my@mail.de</a>` 
- `{{company::tel}}`: Outputs a tel link e.g. `<a href="tel:01234567890">+49 1234 / 56 78 90</a>` 
- `{{company::address}}`: Outputs the full address
