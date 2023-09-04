

-- 1) Primero ingresar los datos a la tabla USERS, la contraseña por defecto es password
INSERT INTO `users`
(`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `expiry_date`, `active`, `created_at`, `updated_at`)
VALUES
(5000, 'Gilberto Lopez Paredes', 'gilberto@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, 1, '2023-04-11 02:31:07', '2023-04-11 02:31:07');

-- 2) Luego ingresar datos a la tabla HR_PER_PEOPLE_F, en user_id colocar el codigo generado en la tabla USERS

INSERT INTO `hr_per_people_f`
(`id`, `first_name`, `second_name`, `first_apell`, `second_apell`, `full_name`, `organization_id`, `document_due_date`, `document_type_id`, `document_num`, `sex`, `posiiton_id`, `avatar`, `status`, `user_id`, `last_updated_by`, `created_at`, `updated_at`, `created_by`)
VALUES
(50, 'Gilberto', NULL, 'Lopez', 'Paredes', 'Gilberto Lopez Paredes', 1, NULL, 1063, '12345678', 'H', NULL, NULL, 'A', 5000, NULL, '2023-04-10 22:31:07', '2023-04-10 22:31:07', 3);



-- 3) Ingresar la relacion de ID entre USER y ROL (Usuario)
INSERT INTO `model_has_roles`
(`role_id`, `model_type`, `model_id`)
VALUES
(3, 'App\\Models\\User', 5000);
