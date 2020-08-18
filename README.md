# TYPO3 extension fetchurl


## Introduction

Extension fetchurl for TYPO3. Basicly a fork for TYPO3 7, 8 and so on.

Fetch an url and show the content in Frontend.
Contained image or link URIs are rewritten accordingly.


## What's the difference to fetch_url from TER?

The editor can select if the content from another website should be grabbed as
static content (CURL) or via iFrame.


## Installation

* Installation is very simple - just install the extension then you can use the plugin


## How to overwrite HTML-Templates?

Just copy the folder Fetch in EXT:fetchurl/Resources/Private/Templates/ to any location and set the new path via
TypoScript setup:

```
plugin.tx_fetchurl {
	view {
		templateRootPaths.1 = EXT:myextension/Resources/Private/Templates/Fetchurl/
	}
}
```


## How to append additional parameter?

It is possible to attach additional parameters to all fetchurl requests. 
This is done with the TypoScript keys "**additionalParameter.static**" and "**additionalParameter.iframe**". 

Existing parameters and the fragment are kept.

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
if a parameter is specified in the url and set in TypoScript, the value of the url is overwritten and the TypoScript 
value is used.

See the example below (for `parameterName=parameterValue`):

| flexform url                                      | final url                                                     |
| ------------------------------------------------- | ------------------------------------------------------------- |
| https://example.com/                              | https://example.com/?parameterName=parameterValue             |
| https://example.com/#c123                         | https://example.com/?parameterName=parameterValue#c123        |
| https://example.com/?id=12#c123                   | https://example.com/?id=12&parameterName=parameterValue#c123  |
| https://example.com/?id=12&parameterName=abc#c123 | https://example.com/?id=12&parameterName=parameterValue#c123  | 


## Signals

| Signal class name                              |  Signal name  | information                                             |
| ---------------------------------------------- | ------------- | ------------------------------------------------------- |
| \In2code\Fetchurl\Domain\Service\FetchService  | afterUrlBuild | after the protocol and additional parameter are added   |
| \In2code\Fetchurl\Domain\Service\FetchService  | getfetchedUrl | after the content fetched                               |
| \In2code\Fetchurl\Domain\Service\IframeService | afterUrlBuild | after the protocol and additional parameter are added   |


## Screenshots

Frontend example:
![Frontend example](Documentation/Images/frontend.png)

Plugin for editors in backend:
![Backend example](Documentation/Images/backend.png)

Example for a privacy save 2-click-solution:
![Backend example](Documentation/Images/iframeswitch.png)


## Changelog

| Version    | Date       | State      | Description                                                                                        |
| ---------- | ---------- | ---------- | -------------------------------------------------------------------------------------------------- |
| 4.3.0      | 2020-08-18 | Feature    | Allow typoscript stdwrap for additionalparameters                                                  |
| 4.2.0      | 2020-08-13 | Feature    | Add typoscript option to add additional parameter to the flexform url, add "afterUrlBuild" signals |
| 4.1.1      | 2020-08-13 | Bugfix     | Replace signalSlogDispatcher phpDoc injection with method injection                                |
| 4.1.0      | 2020-04-24 | Feature    | Declare extension compatible with TYPO3 V10                                                        |
| 4.0.2      | 2020-03-10 | Bugfix     | Remove sandbox-attribute of the iframe                                                             |
| 4.0.1      | 2020-03-02 | Bugfix     | Fix small typo in template file                                                                    |
| 4.0.0      | 2020-02-27 | Feature    | Add a 2-click solution for iframes                                                                 |
| 3.5.0      | 2019-07-29 | Task       | Use subtree split in composer for TYPO3 core                                                       |
| 3.4.0      | 2017-02-18 | !!!Task    | Small refactoring, allow url without protocol                                                      |
| 3.3.1      | 2017-02-16 | Bugfix     | Show additional fields if plugin mode == iframe                                                    |
| 3.3.0      | 2017-02-01 | Feature    | Set iFrame width and scrollbars in FlexForm                                                        |
| 3.2.0      | 2017-02-01 | Feature    | Set iFrame height in FlexForm                                                                      |
| 3.1.0      | 2016-12-22 | Task       | Remove refactor ext_tables.php for T3 8.5 and newer                                                |
| 3.0.2      | 2016-12-02 | Bugfix     | Remove version from composer.json                                                                  |
| 3.0.1      | 2016-12-02 | Bugfix     | Hide not needed tt_content fields                                                                  |
| 3.0.0      | 2016-11-28 | Task       | Add iframe feature                                                                                 |
| 2.0.0      | 2016-05-23 | Initial    | Initial release of the fork of typo3-ter/fetch-url                                                 |
