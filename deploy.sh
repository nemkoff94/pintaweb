#!/bin/sh
# Simple deploy helper: set safe permissions for web hosting
echo "Setting directory permissions to 755 and file permissions to 644..."
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
echo "Done. You may still need to adjust ownership via hosting panel."
