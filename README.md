# Contao Company Bundle
Simple Company integration for Contao 4 Open Source CMS

Creates a simple location mask in the backend settings. The fields can then be inserted anywhere as insert tags. 

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
- `{{company::website}}`

or

- `{{company::mailto}}`: Outputs a link e.g. `<a href="mailto:my@mail.de">my@mail.de</a>` 
- `{{company::address}}`: Outputs the full address

In addition, two more insert tag flags are added:
- remove_specialchars
- trim_all