## Configurações para executar a aplicação

- Configurar o arquivo .env e criar o database respectivo
- Rodar: php artisan migrate 
- Criar o respectivo stored procedure no Banco de Dados:

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_activity_by_id`(IN idx int)
BEGIN
	SELECT activities.id, name, status, begin_date, final_date, situation, description, status_id FROM activities 
	JOIN statuses ON activities.status_id = statuses.id
	WHERE activities.id = idx;
END

- Executar no terminal dentro da pasta raiz do projeto: php artisan serve

## Sobre o Applicativo

Ferramenta de Desenvolvimento: Laravel Framework;
Banco de dados: MySql
Aplicação segue as exigências solicitadas. As validações foram feitas no formulário e no validate do Laravel

##Author

Danniel Covo
