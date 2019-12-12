#!/bin/bash
set -x

cd /var/www/html/notificacoes/storage/slm/new
arq_dia='slm_'$(date +%d%m%Y)'.csv'
log=slm-$(date '+%d-%m-%Y').log

mv slm* ../old

wget http://signs.rerop.coredf.caixa/Aplicacao/Relatórios%20SLM%20de%20Incidentes/$arq_dia >> ${log}

existe=$(echo $?)

if [ $existe -eq 0 ]
then
    echo "Arquivo baixado com sucesso!" >> "$log"

else
    echo "Nao foi possivel baixar o arquivo! Falha no wget" >> "$log"
    mv $log ../log
    exit 1
fi

mv $log ../log
wget -O - http://notificacoes.caixa/index.php/slm/incluir-slm > /dev/null
