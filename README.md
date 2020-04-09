# Contao Company Bundle
Simple integration of company details for Contao 4 Open Source CMS

Adds company detail fields to settings and root pages. Company details in settings are used as fallback if field is not given root page. Details can be called anywhere by the following insert tags:

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

Additional insert tags:

- `{{company::mailto}}`: Outputs a mailto link e.g. `<a href="mailto:my@mail.de">my@mail.de</a>` 
- `{{company::tel}}`: Outputs a tel link e.g. `<a href="tel:01234567890">+49 1234 / 56 78 90</a>` 
- `{{company::address}}`: Outputs the full address
