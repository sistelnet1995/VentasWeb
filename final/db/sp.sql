DROP procedure IF EXISTS `get_ProductosxIdProductoxTiendaxTipoVenta`;
DROP procedure IF EXISTS `get_StockxIdPrecioVenta`;
DROP procedure IF EXISTS `del_ListaDeseoxIdUsuarioxIdProducto`;
DROP procedure IF EXISTS `set_ListaDeseo_IdUsuario_IdProducto`;
DROP procedure IF EXISTS `get_ProductosxProductoxTiendaxIdTipoVenta`;
DROP procedure IF EXISTS `up_Ventas_EstadoVenta`;
DROP procedure IF EXISTS `get_IdPreciosVenta_nStockTienda`;
DROP procedure IF EXISTS `up_PreciosVenta_StockTienda`;
DROP procedure IF EXISTS `get_ClientexIdUsuario`;
DROP procedure IF EXISTS `set_CanjeBono_IdUsuario_IdProducto_CantidadCanjeada`;
DROP procedure IF EXISTS `get_departamentos`;
DROP procedure IF EXISTS `get_ProvinciasxDepartamento`;
DROP procedure IF EXISTS `get_DistritosxProvincia`;
DROP procedure IF EXISTS `get_categorias`;
DROP procedure IF EXISTS `get_SubCategoriasxCategoria`;
DROP procedure IF EXISTS `get_CategoriaxIdCategoria`;
DROP procedure IF EXISTS `get_SubCategoriaxIdSubCategoria`;
DROP procedure IF EXISTS `set_Usuario_Ubigeo_Coordenada_Cliente_Bono`;
DROP procedure IF EXISTS `set_VentasWeb`;
DROP procedure IF EXISTS `set_DetallesVentaWeb`;
DROP procedure IF EXISTS `up_Bonos_IdCliente`;
DROP procedure IF EXISTS `set_EntregasWeb`;
DROP procedure IF EXISTS `up_Monto_IdCliente_IdVenta`;
DROP procedure IF EXISTS `get_UsuarioxUserNamexUserPass`;
DROP procedure IF EXISTS `get_CanjexIdUsuario`;
DROP procedure IF EXISTS `get_DireccionxTienda`;
DROP procedure IF EXISTS `get_DireccionxCliente`;
DROP procedure IF EXISTS `get_ProductosxProductoxTienda`;
DROP procedure IF EXISTS `get_ProductoxIdCategoriaxIdSubCategoriaxPMinxPMaxxTienda`;
DROP procedure IF EXISTS `get_VentasxIdUsuario`;
DROP procedure IF EXISTS `get_ListaDeseoxIdUsuario`;
DROP procedure IF EXISTS `get_ProductosDeseoxIdProducto`;
DROP procedure IF EXISTS `get_DetallesVentaxIdVenta`;
DROP procedure IF EXISTS `get_TiendaxPrimero`;
DROP procedure IF EXISTS `get_Generos`;
DROP procedure IF EXISTS `get_EstadosCivil`;
DROP procedure IF EXISTS `get_PromocionxTienda`;
DROP procedure IF EXISTS `get_tiendas`;
DROP procedure IF EXISTS `get_EntregaxIdVenta`;

DELIMITER $$
CREATE PROCEDURE `get_ProductosxIdProductoxTiendaxTipoVenta`( IN _IdProducto INT, IN _Tienda VARCHAR(40))
BEGIN

	IF _IdProducto IS NULL THEN
		SET @IdProducto = '%';
	ELSE 
		SET @IdProducto =_IdProducto;
    END IF;

	SELECT P.IdProducto, Producto, Descripcion, Peso, Imagen, GROUP_CONCAT(PV.CantidadVenta) AS Cantidades, GROUP_CONCAT(PV.PrecioVenta) AS Precios, PV.Bonos, GROUP_CONCAT(PV.CanjeBonus) AS CanjeBonos, PV.StockTienda, PV.PrecioCompra, PV.Prioridad FROM productos P
	INNER JOIN precios_venta PV ON P.IdProducto = PV.productos_IdProducto
	INNER JOIN tiendas T ON PV.FkTienda = T.IdTienda
	WHERE
	P.IdProducto LIKE @IdProducto AND T.NombreTienda = _Tienda
	AND PV.FkTipoVenta = 2
    AND FechaHoraInicio <= (SYSDATE() - INTERVAL 5 HOUR)
    AND FechaHoraFin >= (SYSDATE() - INTERVAL 5 HOUR)
	AND PV.StockTienda > 0
	GROUP BY productos_IdProducto;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_StockxIdPrecioVenta`( IN _IdPrecioVenta INT)
BEGIN
	SELECT StockTienda FROM precios_venta WHERE IdPrecioVenta = _IdPrecioVenta;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `del_ListaDeseoxIdUsuarioxIdProducto`(IN _IdUsuario VARCHAR(11), IN _IdProducto INT(11))
BEGIN
	DELETE FROM lista_deseo
	WHERE FkIdCliente = (SELECT IdCliente FROM clientes WHERE FkIdUsuario = _IdUsuario)
	AND FkIdProducto = _IdProducto;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `set_ListaDeseo_IdUsuario_IdProducto`(IN _IdUsuario VARCHAR(11), IN _IdProducto INT(11))
BEGIN
	INSERT INTO lista_deseo VALUES (
		null,
		(SELECT IdCliente FROM clientes WHERE FkIdUsuario = _IdUsuario),
		_IdProducto,
		(SELECT CURDATE())
	);
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_ProductosxProductoxTiendaxIdTipoVenta`(IN _Producto VARCHAR(100), IN _Tienda VARCHAR(40))
BEGIN
	SELECT P.IdProducto, Producto, Descripcion, Peso, Imagen, GROUP_CONCAT(PV.CantidadVenta) AS Cantidades, GROUP_CONCAT(PV.PrecioVenta) AS Precios, PV.Bonos, GROUP_CONCAT(PV.CanjeBonus) AS CanjeBonos, PV.StockTienda, PV.PrecioCompra, PV.Prioridad FROM productos P
	INNER JOIN precios_venta PV ON P.IdProducto = PV.productos_IdProducto
	INNER JOIN tiendas T ON PV.FkTienda = T.IdTienda
	WHERE Producto LIKE CONCAT ('%', _Producto, '%') AND T.NombreTienda = _Tienda
	AND PV.FkTipoVenta = 2
	AND FechaHoraInicio <= (SYSDATE() - INTERVAL 5 HOUR)
	AND FechaHoraFin >= (SYSDATE() - INTERVAL 5 HOUR)
	AND PV.StockTienda > 0
	GROUP BY productos_IdProducto;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `up_Ventas_EstadoVenta`(IN _IdEstadoVenta INT(11), IN _IdVenta INT(11))
BEGIN
	UPDATE ventas SET FkIdEstadoVenta = _IdEstadoVenta WHERE IdVenta = _IdVenta;
    
    SET @PagoR = (SELECT (SUM(Cantidad * precio_venta) + V.CostoAdicional) FROM detalles_venta DV INNER JOIN ventas V ON IdVenta = FkVenta WHERE FkVenta = _IdVenta);
    
    SET @IdCliente = (SELECT FkIdCliente FROM ventas WHERE IdVenta = _IdVenta);
    
    SET @Monto = (SELECT Monto FROM clientes WHERE IdCliente = @IdCliente);
    
    UPDATE clientes SET Monto = (@Monto + @PagoR) WHERE IdCliente = @IdCliente;
    
    SET @Bonos = (SELECT Cantidad FROM bonos WHERE FKIdCliente = @IdCliente);
    
    SET @BonosV = (SELECT SUM((SELECT bonos FROM precios_venta WHERE IdPrecioVenta = FkPrecioVenta)) FROM detalles_venta WHERE FkVenta = _IdVenta);
    
	UPDATE bonos SET Cantidad = (@Bonos - @BonosV) WHERE FkIdCliente = @IdCliente;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_IdPreciosVenta_nStockTienda`( IN _IdVenta INT(11))
BEGIN
	SELECT PV.IdPrecioVenta, (DV.Cantidad + PV.StockTienda) AS Stock FROM detalles_venta DV
	INNER JOIN precios_venta PV ON DV.FkPrecioVenta = PV.IdPrecioVenta
	WHERE FkVenta = _IdVenta;
END$$
DELIMITER;


DELIMITER $$
CREATE PROCEDURE `up_PreciosVenta_StockTienda`(IN _IdPrecioVenta INT(11), IN _Stock INT(11))
BEGIN
	UPDATE precios_venta SET StockTienda = _Stock WHERE IdPrecioVenta = _IdPrecioVenta;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_ClientexIdUsuario`(IN _IdCiente INT(11))
BEGIN
	SELECT
    CONCAT(ApellidoP, ' ', ApellidoM, ' ', Nombre) AS NombreC,
    Email,
	FkIdGenero,
	FkIdEstadoCivil,
	FechaNacimiento,
	Direccion,
	Monto,
	Cantidad AS Bonos
	FROM clientes C
	INNER JOIN bonos B ON C.IdCliente = B.FkIdCliente
    INNER JOIN usuarios U ON U.IdUsuario = C.FkIdUsuario
    WHERE FkIdUsuario = _IdCiente;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `set_CanjeBono_IdUsuario_IdProducto_CantidadCanjeada`(
	IN _IdUsuario INT(11),
    IN _IdProducto INT(11),
    IN _Cantidad INT(11),
    IN _BonusCanje INT(11))
BEGIN
	SET @IdCliente = (SELECT IdCliente FROM clientes WHERE FkIdUsuario = _IdUsuario);
    SET @BonosC = (_Cantidad * _BonusCanje);
    
	INSERT INTO canje_bono VALUES
	(null,
	@IdCliente,
	_IdProducto,
	_Cantidad,
	(SELECT CURDATE()),
	(SELECT CURTIME() - INTERVAL 5 HOUR), 
	_BonusCanje);
    
    SET @Bonos = (SELECT Cantidad FROM bonos WHERE FKIdCliente = @IdCliente);
	UPDATE bonos SET Cantidad = (@Bonos - @BonosC) WHERE FkIdCliente = @IdCliente;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_departamentos`()
BEGIN
	SELECT * FROM ventas.departamentos;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_ProvinciasxDepartamento`(IN _IdDepartamento INT)
BEGIN
	SELECT * FROM provincias WHERE FkIdDepartamento = _IdDepartamento;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_DistritosxProvincia`(IN _IdProvincia INT)
BEGIN
	SELECT * FROM distritos WHERE FkIdProvincia = _IdProvincia;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_categorias`()
BEGIN
	SELECT * FROM categorias ORDER BY Categoria ASC;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_SubCategoriasxCategoria`(IN _Categoria INT)
BEGIN
	SELECT * FROM sub_categorias WHERE categorias_IdCategoria = _Categoria ORDER BY SubCategoria ASC;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_CategoriaxIdCategoria`(IN _IdCategoria INT(11))
BEGIN
	SELECT Categoria FROM categorias WHERE IdCategoria = _IdCategoria;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_SubCategoriaxIdSubCategoria`(IN _IdSubCategoria INT(11))
BEGIN
	SELECT SubCategoria FROM sub_categorias WHERE IdSubCategoria = _IdSubCategoria;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `set_Usuario_Ubigeo_Coordenada_Cliente_Bono`(
	IN _Email VARCHAR(40),
    IN _UserName VARCHAR(20),
    IN _UserPass VARCHAR(20),
    IN _Departamento INT(11),
    IN _Provincia INT(11),
    IN _Distrito INT(11),
    IN _Latitud VARCHAR(20),
    IN _Longitud VARCHAR(20),
    IN _IdCliente VARCHAR(11),
    IN _Nombre VARCHAR(40),
    IN _ApellidoP VARCHAR(40),
    IN _ApellidoM VARCHAR(40),
    IN _FkGenero INT(11),
    IN _FkEstadoCivil INT(11),
    IN _FechaNacimiento DATE,
    IN _RazonSocial VARCHAR(200),
    IN _Direccion VARCHAR(100)
)
BEGIN
	DECLARE _IdUsuario INT;
    DECLARE _IdUbigeo INT;
    DECLARE _IdCoordenada INT;
    
	INSERT INTO usuarios VALUES (
		null,
		_Email,
		_UserName,
		_UserPass
	);
    SET _IdUsuario = LAST_INSERT_ID();
    
	INSERT INTO ubigeo VALUES (
		null,
		_Departamento,
		_Provincia,
		_Distrito
	);
    SET _IdUbigeo = LAST_INSERT_ID();
    
    INSERT INTO coordenadas VALUES(
		null,
		_Latitud,
		_Longitud
	);
	SET _IdCoordenada = LAST_INSERT_ID();
    
	INSERT INTO clientes VALUES(
		_IdCliente,
		_IdUsuario,
		_Nombre,
		_ApellidoP,
		_ApellidoM,
		_FkGenero,
		_FkEstadoCivil,
		_FechaNacimiento,
		_RazonSocial,
		_IdUbigeo,
		_Direccion,
		_IdCoordenada,
		0
	);
	INSERT INTO bonos VALUES(
		NULL,
		_IdCliente,
		0
    );
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `set_VentasWeb`(
	IN _IdTipoPago INT(11),
    IN _IdCliente VARCHAR(11),
    IN _CostoAdicional DECIMAL(10, 0),
    IN _NombreTienda VARCHAR(40))
BEGIN
	INSERT INTO ventas(IdVenta, FechaHoraVenta, FkIdTipoPago, FkIdTarjeta, FkIdCliente, FkIdEmpleado, FkIdEstadoVenta, FkIdTipoComprobante, CostoAdicional, FkTienda)
	VALUES (null, (SELECT SYSDATE() - INTERVAL 5 HOUR), _IdTipoPago, null, _IdCliente, null,1,1, _CostoAdicional, (SELECT IdTienda FROM tiendas WHERE NombreTienda = _NombreTienda));
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `set_DetallesVentaWeb`(IN _Cantidad INT(11), IN _IdProducto INT(11), IN _PrecioVenta DECIMAL(10,2), IN _NombreTienda VARCHAR(40))
BEGIN
	SET @IdTienda = (SELECT IdTienda FROM tiendas WHERE NombreTienda = _NombreTienda);
	SET @IdPrecioVenta = (SELECT IdPrecioVenta FROM precios_venta WHERE productos_IdProducto = _IdProducto AND PrecioVenta = _PrecioVenta AND FkTienda = @IdTienda);
	SET @PrecioCompra = (SELECT PrecioCompra FROM precios_venta WHERE IdPrecioVenta = @IdPrecioVenta);
    SET @Stock = (SELECT StockTienda FROM precios_venta WHERE IdPrecioVenta = @IdPrecioVenta);

	INSERT INTO detalles_venta(IdDetalleVenta, FkVenta, Cantidad, FkPrecioVenta, precio_venta, precio_compra)
	VALUES (
		null,
		(SELECT MAX(IdVenta) FROM ventas),
		_Cantidad,
		@IdPrecioVenta,
		_PrecioVenta,
		@PrecioCompra);
        
	UPDATE precios_venta SET StockTienda = (@Stock - _Cantidad) WHERE IdPrecioVenta = @IdPrecioVenta;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `up_Bonos_IdCliente`(IN _IdCliente VARCHAR(11), IN _Bonos INT(11))
BEGIN
	SET @Bonos = (SELECT Cantidad FROM bonos WHERE FKIdCliente = _IdCliente);
	UPDATE bonos SET Cantidad = (_Bonos + @Bonos) WHERE FkIdCliente = _IdCliente;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `set_EntregasWeb`(
	IN _IdCliente VARCHAR(11),
    IN _Direccion VARCHAR(100),
    IN _Departamento VARCHAR(50),
    IN _Provincia VARCHAR(50),
    IN _Distrito VARCHAR(50),
    IN _Latitud VARCHAR(50),
    IN _Longitud VARCHAR(50),
    IN _TipoEntrega INT(11))
BEGIN
	DECLARE _IdUbigeo INT;
    DECLARE _IdCoordenada INT;
    
    IF _TipoEntrega = 2 THEN
		INSERT INTO ubigeo VALUES (null, 
		(SELECT IdDepartamento FROM departamentos WHERE Departamento = _Departamento),
        (SELECT IdProvincia FROM provincias WHERE Provincia = _Provincia),
        (SELECT IdDistrito FROM distritos WHERE Distrito = _Distrito AND FkIdProvincia = (SELECT IdProvincia FROM provincias WHERE Provincia = _Provincia)));
		SET _IdUbigeo = LAST_INSERT_ID();

		INSERT INTO coordenadas (IdCoordenada, Latitud, Longitud) VALUES (null, _Latitud, _Longitud);
		SET _IdCoordenada = LAST_INSERT_ID();
        
        INSERT INTO entregas(IdEntrega, FkVenta, FechaHoraEntrega, FechaEnvio, FkEmpleadoEntrega, FkEstadoEntrega, Observaciones, Volumen, Peso, CodigoEntrega, Direccion, FkUbigeo, FkCoordenada, FkTipoEntrega)
		VALUES(null, (SELECT MAX(IdVenta) FROM ventas), null, null, null, 2, null, null, null,
			(SELECT 11 + ROUND(RAND() * (9999 - 0000))),
			_Direccion, _IdUbigeo, _IdCoordenada, _TipoEntrega);
	ELSE 
		INSERT INTO entregas(IdEntrega, FkVenta, FechaHoraEntrega, FechaEnvio, FkEmpleadoEntrega, FkEstadoEntrega, Observaciones, Volumen, Peso, CodigoEntrega, Direccion, FkUbigeo, FkCoordenada, FkTipoEntrega)
		VALUES(null, (SELECT MAX(IdVenta) FROM ventas), null, null, null, 2, null, null, null,
			(SELECT 11 + ROUND(RAND() * (9999 - 0000))),
			_Direccion, null, null, _TipoEntrega);
        
    END IF;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `up_Monto_IdCliente_IdVenta`(IN _IdCliente VARCHAR(11))
BEGIN
	SET @IdVenta = (SELECT MAX(IdVenta) FROM ventas);
    SET @PagoR = (SELECT (SUM(Cantidad * precio_venta) + V.CostoAdicional) FROM detalles_venta DV INNER JOIN ventas V ON IdVenta = FkVenta WHERE FkVenta = @IdVenta);
    SET @Monto = (SELECT Monto FROM clientes WHERE IdCliente = _IdCliente);
    UPDATE clientes SET Monto = (@Monto - @PagoR) WHERE IdCliente = _IdCliente;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_UsuarioxUserNamexUserPass`(IN _UserName VARCHAR(40), IN _UserPass VARCHAR(20))
BEGIN
	SELECT * FROM usuarios
	WHERE Email = _UserName OR UserName = _UserName AND UserPass = _UserPass;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_CanjexIdUsuario`(IN _IdUsuario INT(11))
BEGIN
	SELECT Producto, Imagen, CantidadCanjeada, FechaCanje, HoraCanje FROM canje_bono CB
	INNER JOIN productos P ON P.IdProducto = CB.FkIdProducto
	INNER JOIN clientes C ON C.IdCliente = CB.FkIdCliente
	WHERE FkIdUsuario = _IdUsuario;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_DireccionxTienda`(IN _Tienda varchar(40))
BEGIN
	SELECT T.NombreTienda, CONCAT(T.Direccion, ', ', D.Departamento, ', ', P.Provincia, ', ', DI.Distrito) As Direccion, C.Latitud, C.Longitud FROM tiendas T
	INNER JOIN ubigeo U ON T.FkUbigeo = U.IdUbigeo
	INNER JOIN departamentos D ON U.FkIdDepartamento = D.IdDepartamento
	INNER JOIN provincias P ON  U.FkIdProvincia = P.IdProvincia
	INNER JOIN distritos DI ON U.FkIdDistrito = DI.IdDistrito
	INNER JOIN coordenadas C ON T.FkCoordenada = C.IdCoordenada
	WHERE T.NombreTienda = _Tienda;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_DireccionxCliente`(IN _IdUsuario INT(11))
BEGIN
	SELECT IdCliente, D.Departamento, P.Provincia, DI.Distrito, Direccion, CO.Latitud, CO.Longitud  FROM clientes C
	INNER JOIN ubigeo U ON C.FkIdUbigeo = U.IdUbigeo
	INNER JOIN departamentos D ON U.FkIdDepartamento = D.IdDepartamento
	INNER JOIN provincias P ON U.FkIdProvincia = P.IdProvincia
	INNER JOIN distritos DI ON U.FkIdDistrito = DI.IdDistrito
	INNER JOIN coordenadas CO ON C.FkIdCoordenada = CO.IdCoordenada
	WHERE FkIdUsuario = _IdUsuario;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_ProductosxProductoxTienda`(IN _Producto VARCHAR(100), IN _Tienda VARCHAR(40))
BEGIN
	SELECT P.IdProducto, Producto, Descripcion, Peso, Imagen, GROUP_CONCAT(PV.CantidadVenta) AS Cantidades, GROUP_CONCAT(PV.PrecioVenta) AS Precios, PV.Bonos, PV.StockTienda, PV.PrecioCompra, PV.Prioridad FROM productos P
	INNER JOIN precios_venta PV ON P.IdProducto = PV.productos_IdProducto
	INNER JOIN tiendas T ON PV.FkTienda = T.IdTienda
	WHERE
	Producto LIKE CONCAT ('%', _Producto, '%') AND T.NombreTienda = _Tienda
	AND PV.FkTipoVenta = 2 AND FechaHoraFin >= (SYSDATE() - INTERVAL 5 HOUR)
	AND PV.StockTienda > 0
	GROUP BY productos_IdProducto;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_ProductoxIdCategoriaxIdSubCategoriaxPMinxPMaxxTienda`(
	IN _IdCategoria INT(11),
    IN _IdSubCategoria INT(11),
    IN _pMin DECIMAL(10,0),
    IN _pMax DECIMAL(10,0),
    IN _Tienda VARCHAR(40))
BEGIN
	SET @IdTienda = (SELECT IdTienda FROM tiendas WHERE NombreTienda = _Tienda);
    
    IF _pMin IS NOT NULL AND _pMax IS NOT NULL AND _IdSubCategoria IS NOT NULL AND _IdCategoria IS NOT NULL THEN
		SELECT P.IdProducto, Producto, P.Descripcion, Peso, Imagen, GROUP_CONCAT(PV.CantidadVenta) AS Cantidades, GROUP_CONCAT(PV.PrecioVenta) AS Precios, PV.Bonos, GROUP_CONCAT(PV.CanjeBonus) AS CanjeBonos, PV.StockTienda, PV.PrecioCompra, PV.Prioridad FROM productos P
		INNER JOIN sub_categorias SC ON P.sub_categorias_IdSubCategoria = SC.IdSubCategoria
		INNER JOIN Categorias C ON SC.categorias_IdCategoria = C.IdCategoria
        INNER JOIN precios_venta PV ON P.IdProducto = PV.productos_IdProducto
		INNER JOIN tiendas T ON PV.FkTienda = T.IdTienda
		WHERE
		PV.FkTienda = @IdTienda AND
        SC.IdSubCategoria = _IdSubCategoria AND PV.PrecioVenta >= _pMin AND PV.PrecioVenta <= _pMax
		AND PV.FkTipoVenta = 2
        AND FechaHoraInicio <= (SYSDATE() - INTERVAL 5 HOUR)
        AND FechaHoraFin >= (SYSDATE() - INTERVAL 5 HOUR)
		AND PV.StockTienda > 0
		GROUP BY productos_IdProducto;
        
	ELSEIF _IdSubCategoria IS NOT NULL AND _IdCategoria IS NOT NULL THEN
		SELECT P.IdProducto, Producto, P.Descripcion, Peso, Imagen, GROUP_CONCAT(PV.CantidadVenta) AS Cantidades, GROUP_CONCAT(PV.PrecioVenta) AS Precios, PV.Bonos, GROUP_CONCAT(PV.CanjeBonus) AS CanjeBonos, PV.StockTienda, PV.PrecioCompra, PV.Prioridad FROM productos P
		INNER JOIN sub_categorias SC ON P.sub_categorias_IdSubCategoria = SC.IdSubCategoria
		INNER JOIN Categorias C ON SC.categorias_IdCategoria = C.IdCategoria
        INNER JOIN precios_venta PV ON P.IdProducto = PV.productos_IdProducto
		INNER JOIN tiendas T ON PV.FkTienda = T.IdTienda
		WHERE
		PV.FkTienda = @IdTienda AND
        SC.IdSubCategoria = _IdSubCategoria
		AND PV.FkTipoVenta = 2
        AND FechaHoraInicio <= (SYSDATE() - INTERVAL 5 HOUR)
        AND FechaHoraFin >= (SYSDATE() - INTERVAL 5 HOUR)
		AND PV.StockTienda > 0
		GROUP BY productos_IdProducto;
		
	ELSEIF _IdCategoria IS NOT NULL THEN
		SELECT P.IdProducto, Producto, P.Descripcion, Peso, Imagen, GROUP_CONCAT(PV.CantidadVenta) AS Cantidades, GROUP_CONCAT(PV.PrecioVenta) AS Precios, PV.Bonos, GROUP_CONCAT(PV.CanjeBonus) AS CanjeBonos, PV.StockTienda, PV.PrecioCompra, PV.Prioridad FROM productos P
		INNER JOIN sub_categorias SC ON P.sub_categorias_IdSubCategoria = SC.IdSubCategoria
		INNER JOIN Categorias C ON SC.categorias_IdCategoria = C.IdCategoria
        INNER JOIN precios_venta PV ON P.IdProducto = PV.productos_IdProducto
		INNER JOIN tiendas T ON PV.FkTienda = T.IdTienda
		WHERE
		PV.FkTienda = @IdTienda AND
        C.IdCategoria = _IdCategoria
		AND PV.FkTipoVenta = 2
        AND FechaHoraInicio <= (SYSDATE() - INTERVAL 5 HOUR)
        AND FechaHoraFin >= (SYSDATE() - INTERVAL 5 HOUR)
		AND PV.StockTienda > 0
		GROUP BY productos_IdProducto;
	END IF;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_VentasxIdUsuario`(IN _IdUsuario INT(11))
BEGIN
	SELECT  IdVenta, CodigoEntrega, EstadoEntrega, FkIdEstadoVenta, NombreTienda FROM ventas V
	INNER JOIN tiendas T ON T.IdTienda = V.FkTienda
	INNER JOIN entregas E ON E.FkVenta = V.IdVenta
	INNER JOIN estados_entregas EE ON EE.IdEstadoEntrega = E.FkEstadoEntrega
	WHERE FkIdCliente = (SELECT IdCliente FROM clientes WHERE FkIdUsuario = _IdUsuario)
	ORDER BY FechaHoraVenta DESC;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_ListaDeseoxIdUsuario`(IN _IdUsuario INT(11))
BEGIN
	SELECT FkIdProducto FROM lista_deseo WHERE FkIdCliente = (SELECT IdCliente FROM clientes WHERE FkIdUsuario = _IdUsuario);
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_ProductosDeseoxIdProducto`(IN _IdProducto INT(11))
BEGIN
	SELECT P.IdProducto, Producto, Descripcion, Peso, Imagen, GROUP_CONCAT(PV.CantidadVenta) AS Cantidades, GROUP_CONCAT(PV.PrecioVenta) AS Precios, PV.Bonos, PV.StockTienda, PV.PrecioCompra, PV.Prioridad FROM productos P
	INNER JOIN precios_venta PV ON P.IdProducto = PV.productos_IdProducto
	INNER JOIN tiendas T ON PV.FkTienda = T.IdTienda
	WHERE
	P.IdProducto LIKE _IdProducto
	GROUP BY productos_IdProducto;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_DetallesVentaxIdVenta`(IN _IdVenta INT(11))
BEGIN
	SELECT P.Imagen, P.Producto, DV.Cantidad, DV.precio_venta FROM precios_venta PV
	INNER JOIN productos P ON PV.productos_IdProducto = P.IdProducto
	INNER JOIN detalles_venta DV ON PV.IdPrecioVenta = DV.FkPrecioVenta
	WHERE DV.FkVenta = _IdVenta;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_TiendaxPrimero`()
BEGIN
	SELECT * FROM tiendas LIMIT 1;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_Generos`()
BEGIN
	SELECT * FROM generos;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_EstadosCivil`()
BEGIN
	SELECT * FROM estados_civil;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_PromocionxTienda`(IN _Tienda VARCHAR(40))
BEGIN
	SELECT P.IdProducto, PR.Imagen FROM promociones PR
	INNER JOIN productos P ON P.IdProducto = PR.productos_IdProducto
	INNER JOIN precios_venta PV ON PV.productos_IdProducto = P.IdProducto
	INNER JOIN tiendas T ON T.IdTienda = PV.FkTienda
	WHERE T.NombreTienda = _Tienda;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_tiendas`()
BEGIN
    SELECT * FROM tiendas T INNER JOIN coordenadas C ON T.FkCoordenada = C.IdCoordenada ORDER BY IdTienda ASC;
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE `get_EntregaxIdVenta`(IN _IdVenta INT(11))
BEGIN
	SELECT FechaHoraVenta, FechaHoraEntrega, FechaEnvio, CONCAT(EM.Nombre, ' ', EM.ApellidoP, ' ', EM.ApellidoM) AS Empleado FROM entregas E
	INNER JOIN ventas V ON E.FkVenta = V.IdVenta
	INNER JOIN empleados EM ON E.FkEmpleadoEntrega = EM.IdEmpleado
	WHERE FkVenta = _IdVenta;
END$$