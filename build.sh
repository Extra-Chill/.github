#!/bin/bash

# Universal Build Script - Redirects to Homeboy
#
# This script is deprecated. Use Homeboy for all build operations:
#
#   homeboy build <component>
#
# Homeboy provides:
# - Universal test infrastructure (PHPUnit, PHPCS, ESLint)
# - Automatic test discovery and execution
# - Production dependency management
# - Frontend asset building
# - Build validation and packaging
#
# For more information: homeboy docs wordpress/build

set -e

echo ""
echo "This build script is deprecated."
echo ""
echo "Use Homeboy for all build operations:"
echo ""
echo "  homeboy build <component>"
echo ""
echo "Example:"
echo "  homeboy build extrachill-seo"
echo "  homeboy build extrachill"
echo ""
exit 1
