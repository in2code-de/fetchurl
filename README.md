# TYPO3 Extension fetchurl

## Purpose

The task of this extension is to fetch an URL from the internet and display it on a website.

## Features

* The fetched URLs can be display inline or as an iframe.
* If the URLs is displayed in an iframe, it is possible to activate an "IFrame-Switch" to ensure privacy

## Installation

### via composer

`composer require in2code/fetchurl`

### via the TYPO3 Extension Manager

* go to the TYPO3 Module "Admin Tools" => "Extensions"
* search for "fetchurl"
* import and activate the extension

or

* download the extension from https://extensions.typo3.org/extension/fetchurl
* go to the TYPO3 Module "Admin Tools" => "Extensions"
* upload the extension (if it's already installed, set the checkmark for "overwrite")
* activate the extension


## Configuration

### Templating

Copy the folder contents from EXT:fetchurl/Resources/Private/Templates/ to any location and set the new path via
TypoScript setup:

```
plugin.tx_fetchurl {
	view {
		templateRootPaths.1 = EXT:myextension/Resources/Private/Templates/Fetchurl/
	}
}
```

### Activate Features

Activate the iframe switch and link to your privacy page

```
plugin.tx_fetchurl_pi1 {
    settings {
        useIframeSwitch = 1 // <- default is "1"
        pidPrivacy = 8945 // replace with your own pid
    }
}

```


### Append additional parameters

It is possible to attach additional parameters to all requests of EXT:fetchurl.\
This is done with the TypoScript keys "**additionalParameter.static**" and "**additionalParameter.iframe**".

Existing parameters and the original fragment are kept.

```
plugin.tx_fetchurl_pi1 {
    settings {
        additionalParameter {
            static {
                # a static value
                foo = bar
                # value with TypoScript stdWrap
                foo2 = TEXT
                foo2.value = bar2
            }

            iframe {
                # a static value
                foo = bar
                # value with TypoScript stdWrap
                foo2 = TEXT
                foo2.value = bar2
            }
        }
    }
}
```

**Note:**
If a parameter is specified in the url and also set by TypoScript, the value in the original url is overwritten and the
value from TypoScript is used.

See the example below (for `parameterName=parameterValue`):

| flexform url                                      | final url                                                     |
| ------------------------------------------------- | ------------------------------------------------------------- |
| https://example.com/                              | https://example.com/?parameterName=parameterValue             |
| https://example.com/#c123                         | https://example.com/?parameterName=parameterValue#c123        |
| https://example.com/?id=12#c123                   | https://example.com/?id=12&parameterName=parameterValue#c123  |
| https://example.com/?id=12&parameterName=abc#c123 | https://example.com/?id=12&parameterName=parameterValue#c123  |


## Events

| Signal class name                              | Event name          | information                                             |
| ---------------------------------------------- |---------------------| ------------------------------------------------------- |
| \In2code\Fetchurl\Domain\Service\FetchService  | AfterUrlBuildEvent  | after the protocol and additional parameter are added   |
| \In2code\Fetchurl\Domain\Service\FetchService  | AfterHtmlFetchEvent | after the content fetched                               |
| \In2code\Fetchurl\Domain\Service\IframeService | AfterUrlBuildEvent  | after the protocol and additional parameter are added   |


## Screenshots

Frontend example:
![Frontend example](Documentation/Images/frontend.png)

Plugin for editors in backend:
![Backend example](Documentation/Images/backend.png)

Example for a privacy save 2-click-solution:
![Backend example](Documentation/Images/iframeswitch.png)


## Changelog

| Version | Date       | State   | Description                                                                                                           |
|---------|------------|---------|-----------------------------------------------------------------------------------------------------------------------|
| 5.0.1   | 2023-07-07 | Bugfix  | two tiny bugfixes                                                                                                     |
| 5.0.0   | 2023-07-07 | Feature | TYPO3 V12 compatibility, switchable controller actions to CTypes, upgrade wizards added, replaced signals with events |
| 4.5.2   | 2021-03-17 | Bugfix  | Add extension key to composer.json, small development updates                                                         |
| 4.5.1   | 2021-03-05 | Bugfix  | Adjust composer.json                                                                                                  |
| 4.5.0   | 2021-03-05 | Feature | Support TYPO3 11                                                                                                      |
| 4.4.2   | 2021-03-04 | Task    | First TER release by @in2code-de                                                                                      |
| 4.4.1   | 2021-02-22 | Bugfix  | Allow urls starting with "//"                                                                                         |
| 4.4.0   | 2020-08-19 | Task    | Don't add empty values to additionalparameters                                                                        |
| 4.3.0   | 2020-08-18 | Feature | Allow typoscript stdwrap for additionalparameters                                                                     |
| 4.2.0   | 2020-08-13 | Feature | Add typoscript option to add additional parameter to the flexform url, add "afterUrlBuild" signals                    |
| 4.1.1   | 2020-08-13 | Bugfix  | Replace signalSlogDispatcher phpDoc injection with method injection                                                   |
| 4.1.0   | 2020-04-24 | Feature | Declare extension compatible with TYPO3 V10                                                                           |
| 4.0.2   | 2020-03-10 | Bugfix  | Remove sandbox-attribute of the iframe                                                                                |
| 4.0.1   | 2020-03-02 | Bugfix  | Fix small typo in template file                                                                                       |
| 4.0.0   | 2020-02-27 | Feature | Add a 2-click solution for iframes                                                                                    |
| 3.5.0   | 2019-07-29 | Task    | Use subtree split in composer for TYPO3 core                                                                          |
| 3.4.0   | 2017-02-18 | !!!Task | Small refactoring, allow url without protocol                                                                         |
| 3.3.1   | 2017-02-16 | Bugfix  | Show additional fields if plugin mode == iframe                                                                       |
| 3.3.0   | 2017-02-01 | Feature | Set iFrame width and scrollbars in FlexForm                                                                           |
| 3.2.0   | 2017-02-01 | Feature | Set iFrame height in FlexForm                                                                                         |
| 3.1.0   | 2016-12-22 | Task    | Remove refactor ext_tables.php for T3 8.5 and newer                                                                   |
| 3.0.2   | 2016-12-02 | Bugfix  | Remove version from composer.json                                                                                     |
| 3.0.1   | 2016-12-02 | Bugfix  | Hide not needed tt_content fields                                                                                     |
| 3.0.0   | 2016-11-28 | Task    | Add iframe feature                                                                                                    |
| 2.0.0   | 2016-05-23 | Initial | Initial release of the fork of typo3-ter/fetch-url                                                                    |
