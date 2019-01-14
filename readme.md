## Para Rodar a aplicação

- configurar o arquivo .env e criar o database respectivo
- Rodar: php artisan migrate 
- Executar Procedure no Banco de Dados:

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_activity_by_id`(IN idx int)
BEGIN
	SELECT activities.id, name, status, begin_date, final_date, situation, description, status_id FROM activities 
	JOIN statuses ON activities.status_id = statuses.id
	WHERE activities.id = idx;
END

## Sobre o Applicativo

Aplicação segue as exigências solicitadas. As validações foram feitas no formulário e no validate do Laravel

##Author

Danniel Covo