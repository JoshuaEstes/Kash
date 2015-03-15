Contributing Guidelines
=======================

To contribute to this project please fork this project and make your changes.
Once you are complete with your changes, open a pull request.

This project uses [Semantic Versioning] and it is advised
that you look this over.

Please see [http://keepachangelog.com](http://keepachangelog.com/) for
documentation on keeping the [CHANGELOG.md] file up to date.

# Coding Standards and Styles

This project makes use of [PSR-1] and [PSR-2] for coding standards and styles.
This project also takes advantage of [PSR-4] to autoload classes and [PSR-3] to
have a standard interface for logging.

Please review these documents before you submit a pull request.

It is also a MUST that a pull request come with a test included and the code
documented.

# Branching Strategy

All development happens on the `master` branch. Other branch names MAY include
names such as `0.1`. This denotes that this branch is the maintenance branch of
version `0.1.x`. This branch will ONLY receive bug fixes.

# Release Strategy

This project will release versions based on [Semantic Versioning]. A release
will be tagged based on the current version or based on bug fixes.

You can browse a list of all current [releases].

## Minor Release Checklist

[] update [CHANGELOG.md] with version that will be tagged, push
[] tag current release, push tag
[] update composer.json with incremented minor, push
[] update [CHANGELOG.md] with unreleased section, push

[PSR-1]: http://www.php-fig.org/psr/psr-1/
[PSR-2]: http://www.php-fig.org/psr/psr-2/
[PSR-3]: http://www.php-fig.org/psr/psr-3/
[PSR-4]: http://www.php-fig.org/psr/psr-4/
[CHANGELOG.md]: https://github.com/JoshuaEstes/Kash/blob/master/CHANGELOG.md
[Semantic Versioning]: http://semver.org/
[releases]: https://github.com/JoshuaEstes/Kash/releases
