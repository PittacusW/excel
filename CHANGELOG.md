# Changelog

All notable changes to `excel` will be documented in this file.

## Unreleased

- added a concrete `PittacusW\Excel\Excel` service and fixed the facade target
- added Laravel 9 through 13 compatibility constraints
- removed the conflicting global `Excel` alias from package discovery
- improved `Export` with filename normalization and automatic headings from associative rows
- improved `Import` so imported rows can be retrieved after execution
- replaced placeholder tests with real package coverage
- added `phpunit.xml.dist`, `phpstan.neon.dist`, and a Laravel 9-13 CI matrix
- rewrote the README to document the actual public API and upgrade notes
