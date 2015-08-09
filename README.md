disjoint-regions
===========


This is my solution to the problem of finding the number of disjoint regions in
a matrix, described in the *Task specification*.

I extended the solution, so that it calculates the number of disjoint regions for
each label (not only 1s). It works also for matrixes that hold more than 2 labels
(not limited to 0-1s). Labels are regarded as strings (of any value). Input matrixes
don't have to be square (N x M are ok).


Task specification
------------------

Write a function that takes a 2-dimensional array of the type shown below and
returns the number of disjoint regions within the array as an integer.

A region is defined as a set of non-zero members of the array which are contiguous
with each other --- that is they are neighbours above, below, left or right of
each other. Note that diagonals are not considered neighbours.

    1101             1001             1001
    1001             1011             1001
    0100             1001             1001
    0000             1100             1111
    
    3 regions        2 regions        1 region


Requirements
------------

PHP client (version >= 5.4.0)


Unit tests
----------

To run the tests, first install [Composer](https://getcomposer.org/doc/00-intro.md).
Then, fetch required vendor libraries by running
[composer install](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies)
in the project directory.

You can run the tests now:

    vendor/bin/phpunit -c config/phpunit.xml
