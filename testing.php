<?php

$string = file_get_contents('C:\Users\icpabelona\Desktop\Code\ebook_classifier\assets\ebooks\ebook6_all_text.txt');

print getOnlyToc($string);

function getOnlyToc($text)
{
    $text = strtolower($text);

    $startIndex = getTOCStartIndex($text);
    $endIndex = getTocEndIndex($text, $startIndex);

    if (!($startIndex >= 0)) {
        echo 'TOC not found!';
    }

    return substr($text, $startIndex, $endIndex);
}

function getTOCStartIndex($text)
{
    $toc_begin = array(
        'table of contents',
        'table of content',
        'contents',
        'content'
    );

    $sub = array(
        'foreword',
        'about the authors',
        'acknowledgment',
        'acknowledgments',
        'copyright',
        'preface',
        'chapter',
        'chapters',
        'introduction',
        '1',
        'I',
        'about the author',
        'part'
    );

    $notToc = array(
        'contents at a glance',
        'contentsataglance',
        'contentataglance',
        'brief contents',
        'briefcontents',
        'brief content',
        'briefcontent'
    );

    $beginIndex = -1;
    $startIndex = -1;

    foreach ($toc_begin as $word) {
        $beginIndex = @stripos($text, $word);

        if ($beginIndex === false) {
            $beginIndex = -1;
        } else {
            break;
        }
    }

    if ($beginIndex >= 0) {
        $temp = -1;

        foreach ($notToc as $word) {
            $temp = @stripos($text, $word, ($beginIndex - 100));

            if ($temp === false) {
                $temp = -1;
            } else {
                break;
            }
        }

        if ($temp < 0) {
            foreach ($sub as $word) {
                $startIndex = @stripos($text, $word, $beginIndex);

                if ($startIndex === false) {
                    $startIndex = -1;
                } else {
                    $startIndex = $beginIndex;
                    break;
                }
            }
        }
    }

    if ($startIndex === -1) {
        $index1 = 0;
        $index2 = 0;
        $index3 = 0;
        $counter = 0;
        
        foreach ($sub as $word) {
            $startIndex = @stripos($text, $word);

            if ($startIndex === false) {
                $startIndex = -1;
            } else {
                switch ($counter) {
                    case 0:
                        $index1 = $startIndex;
                        break;
                    case 1:
                        $index2 = $startIndex;
                        break;
                    case 2:
                        $index3 = $startIndex;
                        break;
                }

                $counter++;

                break;
            }
        }

        if (($index2 - $index1) < 200 && ($index1 > 0 && $index2 > 0 && $index3 > 0)) {
            $startIndex = $index1;
        } else {
            //$startIndex = -1;
        }
    }

    return $startIndex;
}

function getTocEndIndex($text, $start)
{
    $toc_end = array(
        'index',
        'appendixes',
        'bibliography',
        'author index',
        'glossary',
        'references'
    );

    $endIndex = -1;
    $theWord = '';

    foreach ($toc_end as $word) {
        $endIndex = stripos($text, $word, $start);

        if ($endIndex === false) {
            $endIndex = -1;
        } else {
            $theWord = $word;
            break;
        }
    }

    if ($endIndex === -1) {
        $endIndex = strlen($text);
    } else {
        $text = substr($text, $start, $endIndex);
        $temp = $endIndex;
        $endIndex = strripos($text, $theWord);

        if ($endIndex === false) {
            $endIndex = $temp;
        } else {
            $endIndex = $endIndex + strlen($theWord);
        }
    }

    return $endIndex;
}
