#!/bin/bash

#####################################################################
# Função para executar Queries MySQL								#
#####################################################################

function Execute () {

	QUERY=$1

	mysql -e "$QUERY" --user=$USERNAME --password=$PASSWORD --database=$DATABASE

}