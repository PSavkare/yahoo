#!/usr/bin/env bash

# NAME
#     install.sh - Install Travis CI dependencies
#
# SYNOPSIS
#     install.sh
#
# DESCRIPTION
#     Creates the test fixture.

cd "$(dirname "$0")"

# Reuse ORCA's own includes.
source ../../../orca/bin/travis/_includes.sh

# Exit early if no DB fixture is specified.
[[ "$DB_FIXTURE" ]] || exit 0

cd "$ORCA_FIXTURE_DIR/docroot"

mkdir -p sites/default/files
chmod -R 0770 sites/default/files

DB="$TRAVIS_BUILD_DIR/tests/fixtures/$DB_FIXTURE.php.gz"

php core/scripts/db-tools.php import ${DB}

drush php:script "$TRAVIS_BUILD_DIR/tests/update.php"

# Ensure menu_ui is installed.
drush pm-enable menu_ui --yes

drush updatedb --yes
drush update:lightning --no-interaction --yes

orca fixture:enable-extensions

# Reinstall from exported configuration to prove that it's coherent.
drush config:export --yes
drush site:install --yes --existing-config

# Big Pipe interferes with non-JavaScript functional tests, so uninstall it now.
drush pm-uninstall big_pipe --yes

# Set the fixture state to reset to between tests.
orca fixture:backup -f
