#!/usr/bin/env perl -w
use strict;
for my $file (@ARGV) {
    my $out = $file;
    $out =~ s/\.csv$/.json/;
    system("lsc vote.ls < $file > $out");
}
