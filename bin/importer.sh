#!/bin/bash
BASEDIR=$(pwd)
echo $BASEDIR

PROCESSO="importer.php"
CAMINHO="$BASEDIR/$PROCESSO"
OCORRENCIAS=`ps ax | grep $PROCESSO | grep -v grep| wc -l`

echo Verificando servico

sudo php -f importer.php 2> /dev/null &


#if [ $OCORRENCIAS -eq 0 ]; then
#	echo Iniciando importação
#	php -f $CAMINHO 2> /dev/null &
#	echo Processando ...
#fi
