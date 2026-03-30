--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.22
-- Dumped by pg_dump version 13.3

-- Started on 2022-04-09 18:14:56

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 2 (class 3079 OID 35610)
-- Name: tablefunc; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS tablefunc WITH SCHEMA public;


--
-- TOC entry 2627 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION tablefunc; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION tablefunc IS 'functions that manipulate whole tables, including crosstab';


--
-- TOC entry 304 (class 1255 OID 35634)
-- Name: fn_rptventasdiarias_cantidad(date, date); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fn_rptventasdiarias_cantidad(fechainicio date, fechafin date) RETURNS TABLE(clasificador text, tipo text, producto text, dia1 numeric, dia2 numeric, dia3 numeric, dia4 numeric, dia5 numeric, dia6 numeric, dia7 numeric, dia8 numeric, dia9 numeric, dia10 numeric, dia11 numeric, dia12 numeric, dia13 numeric, dia14 numeric, dia15 numeric, dia16 numeric, dia17 numeric, dia18 numeric, dia19 numeric, dia20 numeric, dia21 numeric, dia22 numeric, dia23 numeric, dia24 numeric, dia25 numeric, dia26 numeric, dia27 numeric, dia28 numeric, dia29 numeric, dia30 numeric, dia31 numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
	rec record;
BEGIN
	FOR rec IN (
		select
CASE WHEN split_part(periodo,'-',2) <> 'SUSCRIPCIONES'  THEN 'REVOLVENTE' 
ELSE split_part(periodo,'-',2) END clasificador,
split_part(periodo,'-',2) tipo,
split_part(periodo,'-',3) producto,
coalesce(sum("01"),0) "Día 1", coalesce(sum("02"),0) "Día 2", coalesce(sum("03"),0) "Día 3", coalesce(sum("04"),0) "Día 4", coalesce(sum("05"),0) "Día 5",
coalesce(sum("06"),0) "Día 6", coalesce(sum("07"),0) "Día 7", coalesce(sum("08"),0) "Día 8", coalesce(sum("09"),0) "Día 9", coalesce(sum("10"),0) "Día 10",
coalesce(sum("11"),0) "Día 11", coalesce(sum("12"),0) "Día 12", coalesce(sum("13"),0) "Día 13", coalesce(sum("14"),0) "Día 14", coalesce(sum("15"),0) "Día 15",
coalesce(sum("16"),0) "Día 16", coalesce(sum("17"),0) "Día 17", coalesce(sum("18"),0) "Día 18", coalesce(sum("19"),0) "Día 19", coalesce(sum("20"),0) "Día 20",
coalesce(sum("21"),0) "Día 21", coalesce(sum("22"),0) "Día 22", coalesce(sum("23"),0) "Día 23", coalesce(sum("24"),0) "Día 24", coalesce(sum("25"),0) "Día 25",
coalesce(sum("26"),0) "Día 26", coalesce(sum("27"),0) "Día 27", coalesce(sum("28"),0) "Día 28", coalesce(sum("29"),0) "Día 29", coalesce(sum("30"),0) "Día 30",
coalesce(sum("31"),0) "Día 31"
FROM crosstab('
select
CONCAT(to_char(b.datfechacreo::date,''YYYYMMDD''),''-'',e.strtipo,''-'',d.strnombre) periodo,
to_char(b.datfechacreo::date,''DD'') dia,
sum(b.numcantidad) cantidad_total
FROM public.tblcatfacturaencabezado a
inner join public.tblcatfacturadetalle b on a.intidserie = b.intidfactura
inner join tblcatclientes c on a.intidcliente = c.intidcliente
inner join tblcatproductos d on b.intidproducto = d.intidproducto
inner join tblcattipoproducto e on d.strtipo::integer = e.intidtipoproducto
group by 1,2
order by 1 asc'::text, 'VALUES (''01''::text), (''02''::text), (''03''::text), (''04''::text), (''05''::text), (''06''::text), (''07''::text), (''08''::text), (''09''::text), (''10''::text), (''11''::text), (''12''::text), (''13''::text), (''14''::text), (''15''::text), (''16''::text), (''17''::text), (''18''::text), (''19''::text), (''20''::text), (''21''::text), (''22''::text), (''23''::text), (''24''::text), (''25''::text), (''26''::text), (''27''::text), (''28''::text), (''29''::text), (''30''::text), (''31''::text)'::text) ct(periodo text, "01" numeric, "02" numeric, "03" numeric, "04" numeric, "05" numeric, "06" numeric, "07" numeric, "08" numeric, "09" numeric, "10" numeric, "11" numeric, "12" numeric, "13" numeric, "14" numeric, "15" numeric, "16" numeric, "17" numeric, "18" numeric, "19" numeric, "20" numeric, "21" numeric, "22" numeric, "23" numeric, "24" numeric, "25" numeric, "26" numeric, "27" numeric, "28" numeric, "29" numeric, "30" numeric, "31" numeric)
where split_part(periodo,'-',1)::date between '2021-05-01' and '2021-05-31'
group by 1,2,3
	)
	LOOP
		clasificador := rec.clasificador;
		tipo := rec.tipo;
		producto := rec.producto;
		dia1 := rec."Día 1";
		dia2 := rec."Día 2";
		dia3 := rec."Día 3";
		dia4 := rec."Día 4";
		dia5 := rec."Día 5";
		dia6 := rec."Día 6";
		dia7 := rec."Día 7";
		dia8 := rec."Día 8";
		dia9 := rec."Día 9";
		dia10 := rec."Día 10";
		dia11 := rec."Día 11";
		dia12 := rec."Día 12";
		dia13 := rec."Día 13";
		dia14 := rec."Día 14";
		dia15 := rec."Día 15";
		dia16 := rec."Día 16";
		dia17 := rec."Día 17";
		dia18 := rec."Día 18";
		dia19 := rec."Día 19";
		dia20 := rec."Día 20";
		dia21 := rec."Día 21";
		dia22 := rec."Día 22";
		dia23 := rec."Día 23";
		dia24 := rec."Día 24";
		dia25 := rec."Día 25";
		dia26 := rec."Día 26";
		dia27 := rec."Día 27";
		dia28 := rec."Día 28";
		dia29 := rec."Día 29";
		dia30 := rec."Día 30";
		dia31 := rec."Día 31";
		RETURN NEXT;
	END LOOP;
END
$$;


ALTER FUNCTION public.fn_rptventasdiarias_cantidad(fechainicio date, fechafin date) OWNER TO postgres;

--
-- TOC entry 306 (class 1255 OID 35633)
-- Name: fn_rptventasdiarias_monto(date, date); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fn_rptventasdiarias_monto(fechainicio date, fechafin date) RETURNS TABLE(clasificador text, tipo text, producto text, dia1 numeric, dia2 numeric, dia3 numeric, dia4 numeric, dia5 numeric, dia6 numeric, dia7 numeric, dia8 numeric, dia9 numeric, dia10 numeric, dia11 numeric, dia12 numeric, dia13 numeric, dia14 numeric, dia15 numeric, dia16 numeric, dia17 numeric, dia18 numeric, dia19 numeric, dia20 numeric, dia21 numeric, dia22 numeric, dia23 numeric, dia24 numeric, dia25 numeric, dia26 numeric, dia27 numeric, dia28 numeric, dia29 numeric, dia30 numeric, dia31 numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
	rec record;
BEGIN
	FOR rec IN (
		select
CASE WHEN split_part(periodo,'-',2) <> 'SUSCRIPCIONES'  THEN 'REVOLVENTE' 
ELSE split_part(periodo,'-',2) END clasificador,
split_part(periodo,'-',2) tipo,
split_part(periodo,'-',3) producto,
round(coalesce(sum("01"),0),2) "Día 1", round(coalesce(sum("02"),0),2) "Día 2", round(coalesce(sum("03"),0),2) "Día 3", round(coalesce(sum("04"),0),2) "Día 4", round(coalesce(sum("05"),0),2) "Día 5",
round(coalesce(sum("06"),0),2) "Día 6", round(coalesce(sum("07"),0),2) "Día 7", round(coalesce(sum("08"),0),2) "Día 8", round(coalesce(sum("09"),0),2) "Día 9", round(coalesce(sum("10"),0),2) "Día 10",
round(coalesce(sum("11"),0),2) "Día 11", round(coalesce(sum("12"),0),2) "Día 12", round(coalesce(sum("13"),0),2) "Día 13", round(coalesce(sum("14"),0),2) "Día 14", round(coalesce(sum("15"),0),2) "Día 15",
round(coalesce(sum("16"),0),2) "Día 16", round(coalesce(sum("17"),0),2) "Día 17", round(coalesce(sum("18"),0),2) "Día 18", round(coalesce(sum("19"),0),2) "Día 19", round(coalesce(sum("20"),0),2) "Día 20",
round(coalesce(sum("21"),0),2) "Día 21", round(coalesce(sum("22"),0),2) "Día 22", round(coalesce(sum("23"),0),2) "Día 23", round(coalesce(sum("24"),0),2) "Día 24", round(coalesce(sum("25"),0),2) "Día 25",
round(coalesce(sum("26"),0),2) "Día 26", round(coalesce(sum("27"),0),2) "Día 27", round(coalesce(sum("28"),0),2) "Día 28", round(coalesce(sum("29"),0),2) "Día 29", round(coalesce(sum("30"),0),2) "Día 30",
round(coalesce(sum("31"),0),2) "Día 31"
FROM crosstab('
select
CONCAT(to_char(b.datfechacreo::date,''YYYYMMDD''),''-'',e.strtipo,''-'',d.strnombre) periodo,
to_char(b.datfechacreo::date,''DD'') dia,
COALESCE(sum((b.numcantidad * b.numprecioventa - ((b.numcantidad * b.numprecioventa) * (/*coalesce(a.numdescuentovalor,0) +*/ coalesce(b.numdescuento,0)) )) - ((b.numcantidad * b.numprecioventa - ((b.numcantidad * b.numprecioventa) * (coalesce(b.numdescuento,0)) )) * (coalesce(a.numdescuentovalor,0) /*+ coalesce(b.numdescuento,0)*/) )),0) total
FROM public.tblcatfacturaencabezado a
inner join public.tblcatfacturadetalle b on a.intidserie = b.intidfactura
inner join tblcatclientes c on a.intidcliente = c.intidcliente
inner join tblcatproductos d on b.intidproducto = d.intidproducto
inner join tblcattipoproducto e on d.strtipo::integer = e.intidtipoproducto
group by 1,2
order by 1 asc'::text, 'VALUES (''01''::text), (''02''::text), (''03''::text), (''04''::text), (''05''::text), (''06''::text), (''07''::text), (''08''::text), (''09''::text), (''10''::text), (''11''::text), (''12''::text), (''13''::text), (''14''::text), (''15''::text), (''16''::text), (''17''::text), (''18''::text), (''19''::text), (''20''::text), (''21''::text), (''22''::text), (''23''::text), (''24''::text), (''25''::text), (''26''::text), (''27''::text), (''28''::text), (''29''::text), (''30''::text), (''31''::text)'::text) ct(periodo text, "01" numeric, "02" numeric, "03" numeric, "04" numeric, "05" numeric, "06" numeric, "07" numeric, "08" numeric, "09" numeric, "10" numeric, "11" numeric, "12" numeric, "13" numeric, "14" numeric, "15" numeric, "16" numeric, "17" numeric, "18" numeric, "19" numeric, "20" numeric, "21" numeric, "22" numeric, "23" numeric, "24" numeric, "25" numeric, "26" numeric, "27" numeric, "28" numeric, "29" numeric, "30" numeric, "31" numeric)
where split_part(periodo,'-',1)::date between fechaInicio::date and fechafin::date
group by 1,2,3
	)
	LOOP
		clasificador := rec.clasificador;
		tipo := rec.tipo;
		producto := rec.producto;
		dia1 := rec."Día 1";
		dia2 := rec."Día 2";
		dia3 := rec."Día 3";
		dia4 := rec."Día 4";
		dia5 := rec."Día 5";
		dia6 := rec."Día 6";
		dia7 := rec."Día 7";
		dia8 := rec."Día 8";
		dia9 := rec."Día 9";
		dia10 := rec."Día 10";
		dia11 := rec."Día 11";
		dia12 := rec."Día 12";
		dia13 := rec."Día 13";
		dia14 := rec."Día 14";
		dia15 := rec."Día 15";
		dia16 := rec."Día 16";
		dia17 := rec."Día 17";
		dia18 := rec."Día 18";
		dia19 := rec."Día 19";
		dia20 := rec."Día 20";
		dia21 := rec."Día 21";
		dia22 := rec."Día 22";
		dia23 := rec."Día 23";
		dia24 := rec."Día 24";
		dia25 := rec."Día 25";
		dia26 := rec."Día 26";
		dia27 := rec."Día 27";
		dia28 := rec."Día 28";
		dia29 := rec."Día 29";
		dia30 := rec."Día 30";
		dia31 := rec."Día 31";
		RETURN NEXT;
	END LOOP;
END
$$;


ALTER FUNCTION public.fn_rptventasdiarias_monto(fechainicio date, fechafin date) OWNER TO postgres;

--
-- TOC entry 271 (class 1255 OID 18751)
-- Name: fnactualizar_saldo_cuenta(integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fnactualizar_saldo_cuenta(num_cuenta integer, usuario character varying) RETURNS TABLE(saldo numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
    registro record;
	cuenta numeric;
	totaldebitos numeric;
    totalcreditos numeric;
    debitos numeric;
    creditos numeric;
	saldo numeric;
    codigo_id integer;
BEGIN
   
   -- Cursor IMPLICITO en el ciclo FOR
   FOR registro IN  SELECT intid, intidcuenta cuentas, numdebito debito, numcredito credito
                    FROM tbltrnmovimientos 
                    where intidcuenta = num_cuenta order by intid asc LOOP
					
       codigo_id := registro.intid;
       cuenta := registro.cuentas;
	   debitos:= registro.debito;
	   creditos := registro.credito;
	   
	   totaldebitos :=  (select  coalesce(sum(numdebito),0) from 
						 (
						  select  intid, numdebito from tbltrnmovimientos where intidcuenta = num_cuenta and intid < codigo_id
						  order by intid asc
						 )sub_debito
						);
	   
	   totalcreditos := (select  coalesce(sum(numcredito),0) from 
						 (
						  select  intid, numcredito from tbltrnmovimientos where intidcuenta = num_cuenta and intid < codigo_id
						  order by intid asc
						 )sub_credito 
						);
	  
	  IF debitos > 0 THEN
		    
			UPDATE tbltrnmovimientos
			SET numsaldo = (totalcreditos - totaldebitos) - debitos
			WHERE intid = codigo_id;

			Update tablcatcuentas
			Set balanceinicial = fnsaldo_cuenta(num_cuenta)
			where intidcuenta = num_cuenta;
			
	  END IF;
	  
	  IF creditos > 0 THEN
		   
		    UPDATE tbltrnmovimientos
			SET numsaldo = (totalcreditos - totaldebitos) + creditos
			WHERE intid = codigo_id;
	   
           Update tablcatcuentas
           Set balanceinicial = fnsaldo_cuenta(num_cuenta)
           where intidcuenta = num_cuenta;
	  
	  END IF;
       
       RETURN NEXT;
   END LOOP;
    
   saldo := (select fnsaldo_cuenta saldo_cuenta from fnsaldo_cuenta(num_cuenta));
   
   RETURN;
END
$$;


ALTER FUNCTION public.fnactualizar_saldo_cuenta(num_cuenta integer, usuario character varying) OWNER TO postgres;

--
-- TOC entry 302 (class 1255 OID 18752)
-- Name: fncompra_calcular_saldo_cuenta(integer, integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fncompra_calcular_saldo_cuenta(num_factura integer, num_cuenta integer, usuario character varying) RETURNS TABLE(saldo numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
    registro record;
	cuenta numeric;
	totaldebitos numeric;
    totalcreditos numeric;
    debitos numeric;
    creditos numeric;
	numero_referencia integer;
	referencia text;
    resultado numeric;
	saldo numeric;
BEGIN
   
   -- Cursor IMPLICITO en el ciclo FOR
   FOR registro IN  SELECT num_cuenta::integer cuentas,  numtotal debito, 0 credito, numerofactura numreferencia, 
                    'COMPRA'::TEXT referencia 
                    FROM tblcatfacturaencabezado_compra where numerofactura = num_factura LOOP
			
       cuenta := registro.cuentas;
	   debitos:= registro.debito;
	   creditos := registro.credito;
	   numero_referencia := registro.numreferencia;
	   referencia := registro.referencia;
	   
	   totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   
INSERT INTO public.tbltrnmovimientos
(intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo,numreferencia,strreferencia)
VALUES (cuenta, debitos, creditos, (totalcreditos - totaldebitos) - debitos, current_timestamp AT time zone 'CST6', usuario,
	   numero_referencia,referencia);
	   
Update tablcatcuentas
Set balanceinicial = fnsaldo_cuenta(num_cuenta)
where intidcuenta = num_cuenta;

saldo := (select totalcreditos - totaldebitos) - debitos;
       
       RETURN NEXT;
   END LOOP;
   RETURN;
END
$$;


ALTER FUNCTION public.fncompra_calcular_saldo_cuenta(num_factura integer, num_cuenta integer, usuario character varying) OWNER TO postgres;

--
-- TOC entry 294 (class 1255 OID 18753)
-- Name: fncompra_calcular_saldo_cuenta_all(integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fncompra_calcular_saldo_cuenta_all(num_cuenta integer, usuario character varying) RETURNS TABLE(saldo numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
    registro record;
	cuenta numeric;
	totaldebitos numeric;
    totalcreditos numeric;
    debitos numeric;
    creditos numeric;
	numero_referencia integer;
	referencia text;
    resultado numeric;
	saldo numeric;
BEGIN
   
   -- Cursor IMPLICITO en el ciclo FOR
   FOR registro IN  SELECT 2::integer cuentas,  numtotal debito, 0 credito, numerofactura numreferencia, 
                    'COMPRA'::TEXT referencia 
                    FROM tblcatfacturaencabezado_compra LOOP
			
       cuenta := registro.cuentas;
	   debitos:= registro.debito;
	   creditos := registro.credito;
	   numero_referencia := registro.numreferencia;
	   referencia := registro.referencia;
	   
	   totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   
INSERT INTO public.tbltrnmovimientos
(intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo,numreferencia,strreferencia)
VALUES (cuenta, debitos, creditos, (totalcreditos - totaldebitos) - debitos, current_timestamp AT time zone 'CST6', usuario,
	   numero_referencia,referencia);
	   
Update tablcatcuentas
Set balanceinicial = fnsaldo_cuenta(num_cuenta)
where intidcuenta = num_cuenta;

saldo := (select totalcreditos - totaldebitos) - debitos;
       
       RETURN NEXT;
   END LOOP;
   RETURN;
END
$$;


ALTER FUNCTION public.fncompra_calcular_saldo_cuenta_all(num_cuenta integer, usuario character varying) OWNER TO postgres;

--
-- TOC entry 303 (class 1255 OID 19189)
-- Name: fncompracredito_calcular_saldo_cuenta(integer, integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fncompracredito_calcular_saldo_cuenta(num_factura integer, num_cuenta integer, usuario character varying) RETURNS TABLE(saldo numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
    registro record;
	cuenta numeric;
	totaldebitos numeric;
    totalcreditos numeric;
    debitos numeric;
    creditos numeric;
	numero_referencia integer;
	referencia text;
    resultado numeric;
	saldo numeric;
BEGIN
   
   -- Cursor IMPLICITO en el ciclo FOR
   FOR registro IN  SELECT num_cuenta::integer cuentas,  0 debito, numtotal credito, numerofactura numreferencia, 
                    'COMPRA'::TEXT referencia 
                    FROM tblcatfacturaencabezado_compra where numerofactura = num_factura LOOP
			
       cuenta := registro.cuentas;
	   debitos:= registro.debito;
	   creditos := registro.credito;
	   numero_referencia := registro.numreferencia;
	   referencia := registro.referencia;
	   
	   totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   
INSERT INTO public.tbltrnmovimientos
(intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo,numreferencia,strreferencia)
VALUES (cuenta, debitos, creditos, (totalcreditos - totaldebitos) + creditos, current_timestamp AT time zone 'CST6' , usuario,
	    numero_referencia,referencia);
	   
Update tablcatcuentas
Set balanceinicial = fnsaldo_cuenta(num_cuenta)
where intidcuenta = num_cuenta;

saldo := (select totalcreditos - totaldebitos) + creditos;
       
       RETURN NEXT;
   END LOOP;
   RETURN;
END
$$;


ALTER FUNCTION public.fncompracredito_calcular_saldo_cuenta(num_factura integer, num_cuenta integer, usuario character varying) OWNER TO postgres;

--
-- TOC entry 295 (class 1255 OID 18754)
-- Name: fngasto_calcular_saldo_cuenta(integer, integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fngasto_calcular_saldo_cuenta(num_documento integer, num_cuenta integer, usuario character varying) RETURNS TABLE(saldo numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
    registro record;
	cuenta numeric;
	totaldebitos numeric;
    totalcreditos numeric;
    debitos numeric;
    creditos numeric;
	numero_referencia integer;
	referencia text;
    resultado numeric;
	saldo numeric;
BEGIN
   
   -- Cursor IMPLICITO en el ciclo FOR
   FOR registro IN  select intidcuenta cuentas, nummonto debito, 0 credito, intidreggasto numreferencia,
                    'GASTO'::TEXT referencia 
                     from tbltrngastos
                     where intidreggasto = num_documento LOOP
			
       cuenta := registro.cuentas;
	   debitos:= registro.debito;
	   creditos := registro.credito;
	   numero_referencia := registro.numreferencia;
	   referencia := registro.referencia;
	   
	   totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   
INSERT INTO public.tbltrnmovimientos
(intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo,numreferencia,strreferencia)
VALUES (cuenta, debitos, creditos, (totalcreditos - totaldebitos) - debitos, current_timestamp AT time zone 'CST6', usuario,
	    numero_referencia,referencia);
	   
Update tablcatcuentas
Set balanceinicial = fnsaldo_cuenta(num_cuenta)
where intidcuenta = num_cuenta;

saldo := (select totalcreditos - totaldebitos) - debitos;
       
       RETURN NEXT;
   END LOOP;
   RETURN;
END
$$;


ALTER FUNCTION public.fngasto_calcular_saldo_cuenta(num_documento integer, num_cuenta integer, usuario character varying) OWNER TO postgres;

--
-- TOC entry 296 (class 1255 OID 18755)
-- Name: fningreso_calcular_saldo_cuenta(integer, integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fningreso_calcular_saldo_cuenta(num_documento integer, num_cuenta integer, usuario character varying) RETURNS TABLE(saldo numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
    registro record;
	cuenta numeric;
	totaldebitos numeric;
    totalcreditos numeric;
    debitos numeric;
    creditos numeric;
	numero_referencia integer;
	referencia text;
    resultado numeric;
	saldo numeric;
BEGIN
   
   -- Cursor IMPLICITO en el ciclo FOR
   FOR registro IN  select a.intidcuenta cuentas, 0 debito, a.nummonto credito, a.intidregingreso numreferencia,
                    'INGRESO'::TEXT referencia 
                    from tbltrningresos a
                    where a.intidregingreso = num_documento LOOP
			
       cuenta := registro.cuentas;
	   debitos:= registro.debito;
	   creditos := registro.credito;
	   numero_referencia := registro.numreferencia;
	   referencia := registro.referencia;
	   
	   totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   
INSERT INTO public.tbltrnmovimientos
(intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo,numreferencia,strreferencia)
VALUES (cuenta, debitos, creditos, (totalcreditos - totaldebitos) + creditos, current_timestamp AT time zone 'CST6', usuario,
	    numero_referencia,referencia);
	   
Update tablcatcuentas
Set balanceinicial = fnsaldo_cuenta(num_cuenta)
where intidcuenta = num_cuenta;

saldo := (select totalcreditos - totaldebitos) + creditos;
       
       RETURN NEXT;
   END LOOP;
   RETURN;
END
$$;


ALTER FUNCTION public.fningreso_calcular_saldo_cuenta(num_documento integer, num_cuenta integer, usuario character varying) OWNER TO postgres;

--
-- TOC entry 297 (class 1255 OID 18756)
-- Name: fnrecibo_calcular_saldo_cuenta(integer, integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fnrecibo_calcular_saldo_cuenta(num_recibo integer, num_cuenta integer, usuario character varying) RETURNS TABLE(saldo numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
    registro record;
	cuenta numeric;
	totaldebitos numeric;
    totalcreditos numeric;
    debitos numeric;
    creditos numeric;
	numero_referencia integer;
	referencia text;
    resultado numeric;
	saldo numeric;
BEGIN
   
   -- Cursor IMPLICITO en el ciclo FOR
   FOR registro IN  SELECT num_cuenta::integer cuentas,  0 debito, numtotal_cobrado credito, intnumdocumento numreferencia, 
                    'RECIBO'::TEXT referencia 
                    FROM public.tbltrnpagos where intnumdocumento = num_recibo LOOP
			
       cuenta := registro.cuentas;
	   debitos:= registro.debito;
	   creditos := registro.credito;
	   numero_referencia := registro.numreferencia;
	   referencia := registro.referencia;
	   
	   totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   
INSERT INTO public.tbltrnmovimientos
(intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo,numreferencia,strreferencia)
VALUES (cuenta, debitos, creditos, (totalcreditos - totaldebitos) + creditos, current_timestamp AT time zone 'CST6' , usuario,
	    numero_referencia,referencia);
	   
Update tablcatcuentas
Set balanceinicial = fnsaldo_cuenta(num_cuenta)
where intidcuenta = num_cuenta;

saldo := (select totalcreditos - totaldebitos) + creditos;
       
       RETURN NEXT;
   END LOOP;
   RETURN;
END
$$;


ALTER FUNCTION public.fnrecibo_calcular_saldo_cuenta(num_recibo integer, num_cuenta integer, usuario character varying) OWNER TO postgres;

--
-- TOC entry 301 (class 1255 OID 19188)
-- Name: fnrecibo_calcular_saldo_cuenta2(integer, integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fnrecibo_calcular_saldo_cuenta2(num_recibo integer, num_cuenta integer, usuario character varying) RETURNS TABLE(saldo numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
    registro record;
	cuenta numeric;
	totaldebitos numeric;
    totalcreditos numeric;
    debitos numeric;
    creditos numeric;
	numero_referencia integer;
	referencia text;
    resultado numeric;
	saldo numeric;
BEGIN
   
   -- Cursor IMPLICITO en el ciclo FOR
   FOR registro IN  SELECT num_cuenta::integer cuentas,  numtotal_cobrado debito, 0 credito, intnumdocumento numreferencia, 
                    'RECIBO'::TEXT referencia 
                    FROM public.tbltrnpagos where intnumdocumento = num_recibo LOOP
			
       cuenta := registro.cuentas;
	   debitos:= registro.debito;
	   creditos := registro.credito;
	   numero_referencia := registro.numreferencia;
	   referencia := registro.referencia;
	   
	   totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   
INSERT INTO public.tbltrnmovimientos
(intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo,numreferencia,strreferencia)
VALUES (cuenta, debitos, creditos, (totalcreditos - totaldebitos) - debitos, current_timestamp AT time zone 'CST6' , usuario,
	    numero_referencia,referencia);
	   
Update tablcatcuentas
Set balanceinicial = fnsaldo_cuenta(num_cuenta)
where intidcuenta = num_cuenta;

saldo := (select totalcreditos - totaldebitos) + creditos;
       
       RETURN NEXT;
   END LOOP;
   RETURN;
END
$$;


ALTER FUNCTION public.fnrecibo_calcular_saldo_cuenta2(num_recibo integer, num_cuenta integer, usuario character varying) OWNER TO postgres;

--
-- TOC entry 305 (class 1255 OID 43840)
-- Name: fnrecibocxp_calcular_saldo_cuenta(integer, integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fnrecibocxp_calcular_saldo_cuenta(num_recibo integer, num_cuenta integer, usuario character varying) RETURNS TABLE(saldo numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
    registro record;
	cuenta numeric;
	totaldebitos numeric;
    totalcreditos numeric;
    debitos numeric;
    creditos numeric;
	numero_referencia integer;
	referencia text;
    resultado numeric;
	saldo numeric;
BEGIN
   
   -- Cursor IMPLICITO en el ciclo FOR
   FOR registro IN  SELECT num_cuenta::integer cuentas,  numtotal_cobrado debito, 0 credito, intnumdocumento numreferencia, 
                    'RECIBO_CXP'::TEXT referencia 
                    FROM public.tbltrnpagos_cxp where intnumdocumento = num_recibo LOOP
			
       cuenta := registro.cuentas;
	   debitos:= registro.debito;
	   creditos := registro.credito;
	   numero_referencia := registro.numreferencia;
	   referencia := registro.referencia;
	   
	   totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   
INSERT INTO public.tbltrnmovimientos
(intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo,numreferencia,strreferencia)
VALUES (cuenta, debitos, creditos, (totalcreditos - totaldebitos) - debitos, current_timestamp AT time zone 'CST6' , usuario,
	    numero_referencia,referencia);
	   
Update tablcatcuentas
Set balanceinicial = fnsaldo_cuenta(num_cuenta)
where intidcuenta = num_cuenta;

saldo := (select totalcreditos - totaldebitos) + creditos;
       
       RETURN NEXT;
   END LOOP;
   RETURN;
END
$$;


ALTER FUNCTION public.fnrecibocxp_calcular_saldo_cuenta(num_recibo integer, num_cuenta integer, usuario character varying) OWNER TO postgres;

--
-- TOC entry 307 (class 1255 OID 43841)
-- Name: fnrecibocxp_calcular_saldo_cuenta2(integer, integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fnrecibocxp_calcular_saldo_cuenta2(num_recibo integer, num_cuenta integer, usuario character varying) RETURNS TABLE(saldo numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
    registro record;
	cuenta numeric;
	totaldebitos numeric;
    totalcreditos numeric;
    debitos numeric;
    creditos numeric;
	numero_referencia integer;
	referencia text;
    resultado numeric;
	saldo numeric;
BEGIN
   
   -- Cursor IMPLICITO en el ciclo FOR
   FOR registro IN  SELECT num_cuenta::integer cuentas,  numtotal_cobrado debito, 0 credito, intnumdocumento numreferencia, 
                    'RECIBO_CXP'::TEXT referencia 
                    FROM public.tbltrnpagos_cxp where intnumdocumento = num_recibo LOOP
			
       cuenta := registro.cuentas;
	   debitos:= registro.debito;
	   creditos := registro.credito;
	   numero_referencia := registro.numreferencia;
	   referencia := registro.referencia;
	   
	   totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   
INSERT INTO public.tbltrnmovimientos
(intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo,numreferencia,strreferencia)
VALUES (cuenta, debitos, creditos, (totalcreditos - totaldebitos) - debitos, current_timestamp AT time zone 'CST6' , usuario,
	    numero_referencia,referencia);
	   
Update tablcatcuentas
Set balanceinicial = fnsaldo_cuenta(num_cuenta)
where intidcuenta = num_cuenta;

saldo := (select totalcreditos - totaldebitos) + creditos;
       
       RETURN NEXT;
   END LOOP;
   RETURN;
END
$$;


ALTER FUNCTION public.fnrecibocxp_calcular_saldo_cuenta2(num_recibo integer, num_cuenta integer, usuario character varying) OWNER TO postgres;

--
-- TOC entry 298 (class 1255 OID 18757)
-- Name: fnsaldo_cuenta(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fnsaldo_cuenta(valor integer) RETURNS numeric
    LANGUAGE plpgsql
    AS $$
declare totaldebitos numeric;
        totalcreditos numeric;
	    saldo numeric;
begin
    totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = valor);
	   
	totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = valor);
	
	saldo := (select totalcreditos - totaldebitos);
    
	RETURN saldo;
end;
$$;


ALTER FUNCTION public.fnsaldo_cuenta(valor integer) OWNER TO postgres;

--
-- TOC entry 269 (class 1255 OID 18758)
-- Name: fnsaldo_cuenta_por_fecha(integer, date, date); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fnsaldo_cuenta_por_fecha(valor integer, fecha_inicio date, fecha_final date) RETURNS numeric
    LANGUAGE plpgsql
    AS $$
declare totaldebitos numeric;
        totalcreditos numeric;
	    saldo numeric;
begin
    totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = valor and datfechacreo::date between fecha_inicio and fecha_final);
	   
	totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = valor and datfechacreo::date between fecha_inicio and fecha_final);
	
	saldo := (select totalcreditos - totaldebitos);
    
	RETURN saldo;
end;
$$;


ALTER FUNCTION public.fnsaldo_cuenta_por_fecha(valor integer, fecha_inicio date, fecha_final date) OWNER TO postgres;

--
-- TOC entry 299 (class 1255 OID 18759)
-- Name: fntransfe_calcular_saldo_cuenta(integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fntransfe_calcular_saldo_cuenta(num_documento integer, usuario character varying) RETURNS TABLE(saldo numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
    registro record;
	registros record;
	cuenta numeric;
	totaldebitos numeric;
    totalcreditos numeric;
    debitos numeric;
    creditos numeric;
	numero_referencia integer;
	referencia text;
    resultado numeric;
	saldo numeric;
BEGIN
   
   -- INICIA Cursor IMPLICITO en el ciclo FOR PARA DEBITAR DE LA CUENTA SELECCIONADA
   FOR registro IN   select intidcuentadebitada cuentas, nummonto debito, 0 credito, intidtransferencia numreferencia,
                    'RETIRO'::TEXT referencia
                     from tbltrntranferencia
                     where intidtransferencia =  num_documento LOOP
			
       cuenta := registro.cuentas;
	   debitos:= registro.debito;
	   creditos := registro.credito;
	   numero_referencia := registro.numreferencia;
	   referencia := registro.referencia;
	   
	   totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = cuenta);
	   
	   totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = cuenta);
	   
	   
INSERT INTO public.tbltrnmovimientos
(intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo,numreferencia,strreferencia)
VALUES (cuenta, debitos, creditos, (totalcreditos - totaldebitos) - debitos, current_timestamp AT time zone 'CST6', usuario,
	    numero_referencia,referencia);
	   
Update tablcatcuentas
Set balanceinicial = fnsaldo_cuenta(cuenta::integer)
where intidcuenta = cuenta;

saldo := (select totalcreditos - totaldebitos) - debitos;
       
       RETURN NEXT;
   END LOOP;
   -- FINALIZA Cursor IMPLICITO en el ciclo FOR PARA DEBITAR DE LA CUENTA SELECCIONADA
   
   -- INICIA Cursor IMPLICITO en el ciclo FOR PARA ACREDITAR EN LA CUENTA SELECCIONADA
   FOR registros IN  select intidcuentaacreditada cuentas, 0 debito, nummonto credito, intidtransferencia numreferencia,
                    'DEPOSITO'::TEXT referencia
                     from tbltrntranferencia
                     where intidtransferencia = num_documento LOOP
			
       cuenta := registros.cuentas;
	   debitos:= registros.debito;
	   creditos := registros.credito;
	   numero_referencia := registros.numreferencia;
	   referencia := registros.referencia;
	   
	   totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = cuenta);
	   
	   totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = cuenta);
	   
	   
INSERT INTO public.tbltrnmovimientos
(intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo,numreferencia,strreferencia)
VALUES (cuenta, debitos, creditos, (totalcreditos - totaldebitos) + creditos, current_timestamp AT time zone 'CST6', usuario,
	    numero_referencia,referencia);
	   
Update tablcatcuentas
Set balanceinicial = fnsaldo_cuenta(cuenta::integer)
where intidcuenta = cuenta;

saldo := (select totalcreditos - totaldebitos) + creditos;
       
       RETURN NEXT;
   END LOOP;
   -- INICIA Cursor IMPLICITO en el ciclo FOR PARA ACREDITAR EN LA CUENTA SELECCIONADA
   
   RETURN;
END
$$;


ALTER FUNCTION public.fntransfe_calcular_saldo_cuenta(num_documento integer, usuario character varying) OWNER TO postgres;

--
-- TOC entry 300 (class 1255 OID 18760)
-- Name: fnventa_calcular_saldo_cuenta(integer, integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fnventa_calcular_saldo_cuenta(num_factura integer, num_cuenta integer, usuario character varying) RETURNS TABLE(saldo numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
    registro record;
	cuenta numeric;
	totaldebitos numeric;
    totalcreditos numeric;
    debitos numeric;
    creditos numeric;
	numero_referencia integer;
	referencia text;
    resultado numeric;
	saldo numeric;
BEGIN
   
   -- Cursor IMPLICITO en el ciclo FOR
   FOR registro IN  SELECT num_cuenta::integer cuentas,  0 debito, numtotal credito, numerofactura numreferencia, 
                    'VENTA'::TEXT referencia 
                    FROM tblcatfacturaencabezado where numerofactura = num_factura LOOP
			
       cuenta := registro.cuentas;
	   debitos:= registro.debito;
	   creditos := registro.credito;
	   numero_referencia := registro.numreferencia;
	   referencia := registro.referencia;
	   
	   totaldebitos :=  (select  sum(numdebito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   totalcreditos := (select  sum(numcredito) from tbltrnmovimientos where intidcuenta = num_cuenta);
	   
	   
INSERT INTO public.tbltrnmovimientos
(intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo,numreferencia,strreferencia)
VALUES (cuenta, debitos, creditos, (totalcreditos - totaldebitos) + creditos, current_timestamp AT time zone 'CST6' , usuario,
	    numero_referencia,referencia);
	   
Update tablcatcuentas
Set balanceinicial = fnsaldo_cuenta(num_cuenta)
where intidcuenta = num_cuenta;

saldo := (select totalcreditos - totaldebitos) + creditos;
       
       RETURN NEXT;
   END LOOP;
   RETURN;
END
$$;


ALTER FUNCTION public.fnventa_calcular_saldo_cuenta(num_factura integer, num_cuenta integer, usuario character varying) OWNER TO postgres;

SET default_tablespace = '';

--
-- TOC entry 196 (class 1259 OID 18761)
-- Name: hora; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hora (
    id integer NOT NULL,
    fecha_hora timestamp without time zone
);


ALTER TABLE public.hora OWNER TO postgres;

--
-- TOC entry 197 (class 1259 OID 18764)
-- Name: tablcatcuentas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tablcatcuentas (
    intidcuenta integer NOT NULL,
    strnombrecuenta character varying(100),
    strrazon character varying(20),
    bolactivo boolean,
    balanceinicial numeric,
    usuariocreo character varying(50),
    datfechacreo timestamp with time zone
);


ALTER TABLE public.tablcatcuentas OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 18770)
-- Name: tablcatcuentas_intidcuenta_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tablcatcuentas_intidcuenta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tablcatcuentas_intidcuenta_seq OWNER TO postgres;

--
-- TOC entry 2628 (class 0 OID 0)
-- Dependencies: 198
-- Name: tablcatcuentas_intidcuenta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tablcatcuentas_intidcuenta_seq OWNED BY public.tablcatcuentas.intidcuenta;


--
-- TOC entry 199 (class 1259 OID 18772)
-- Name: tblcatclientes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatclientes (
    intidcliente integer NOT NULL,
    bigcodcliente bigint NOT NULL,
    strpnombre character varying(50) NOT NULL,
    strsnombre character varying(50),
    strpapellido character varying(50) NOT NULL,
    strsapellido character varying(50),
    strsexo character varying(50),
    stridentificacion character varying(30),
    strcorreo character varying(50),
    strtelefono character varying(50),
    strcontacto character varying(50),
    strfechadenacimiento date,
    strdireccion text,
    intaltura numeric,
    intpeso numeric,
    strgymanterior character varying(250),
    intanioentrenando integer,
    strimagen text,
    strusuariocreo character varying(50),
    datfechacreo timestamp without time zone,
    strusuariomodifico character varying(50),
    datfechamodifico timestamp without time zone,
    bolactivo boolean DEFAULT true
);


ALTER TABLE public.tblcatclientes OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 18779)
-- Name: tblcatclientes_intidcliente_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatclientes_intidcliente_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatclientes_intidcliente_seq OWNER TO postgres;

--
-- TOC entry 2629 (class 0 OID 0)
-- Dependencies: 200
-- Name: tblcatclientes_intidcliente_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatclientes_intidcliente_seq OWNED BY public.tblcatclientes.intidcliente;


--
-- TOC entry 201 (class 1259 OID 18781)
-- Name: tblcatdescuento; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatdescuento (
    intidimpuesto integer NOT NULL,
    descripcion character varying(50) NOT NULL,
    numvalor numeric NOT NULL,
    bolactivo boolean DEFAULT true
);


ALTER TABLE public.tblcatdescuento OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 18787)
-- Name: tblcatdescuento_intidimpuesto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatdescuento_intidimpuesto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatdescuento_intidimpuesto_seq OWNER TO postgres;

--
-- TOC entry 2630 (class 0 OID 0)
-- Dependencies: 202
-- Name: tblcatdescuento_intidimpuesto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatdescuento_intidimpuesto_seq OWNED BY public.tblcatdescuento.intidimpuesto;


--
-- TOC entry 203 (class 1259 OID 18789)
-- Name: tblcatexistencia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatexistencia (
    intidserie integer NOT NULL,
    intidproducto integer NOT NULL,
    strnombreproducto character varying(250) NOT NULL,
    intexistencia integer NOT NULL,
    numcosto numeric NOT NULL,
    total numeric NOT NULL,
    datfechacreo timestamp without time zone NOT NULL,
    strusuariocreo character varying(50) NOT NULL,
    datfechamodifico timestamp without time zone,
    strusuariomodifico character varying(50)
);


ALTER TABLE public.tblcatexistencia OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 18795)
-- Name: tblcatexistencia_intidserie_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatexistencia_intidserie_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatexistencia_intidserie_seq OWNER TO postgres;

--
-- TOC entry 2631 (class 0 OID 0)
-- Dependencies: 204
-- Name: tblcatexistencia_intidserie_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatexistencia_intidserie_seq OWNED BY public.tblcatexistencia.intidserie;


--
-- TOC entry 205 (class 1259 OID 18797)
-- Name: tblcatfacturadetalle; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatfacturadetalle (
    intidserie integer NOT NULL,
    intidfactura integer NOT NULL,
    intidproducto integer NOT NULL,
    numcantidad integer,
    strdescripcionproducto character varying(500),
    numprecioventa numeric,
    numsubttotal numeric,
    numdescuento numeric,
    numtotal numeric,
    strusuariocreo character varying(50) NOT NULL,
    datfechacreo timestamp without time zone NOT NULL,
    datfechamodifico timestamp without time zone,
    strusuariomodifico character varying(50),
    numimpuesto numeric,
    numcosto numeric
);


ALTER TABLE public.tblcatfacturadetalle OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 18803)
-- Name: tblcatfacturadetalle_compra; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatfacturadetalle_compra (
    intidserie integer NOT NULL,
    intidfactura integer NOT NULL,
    intidproducto integer NOT NULL,
    numcantidad integer,
    strdescripcionproducto character varying(500),
    numprecioventa numeric,
    numsubttotal numeric,
    numdescuento numeric,
    numtotal numeric,
    strusuariocreo character varying(50) NOT NULL,
    datfechacreo timestamp without time zone NOT NULL,
    datfechamodifico timestamp without time zone,
    strusuariomodifico character varying(50),
    numimpuesto numeric,
    numcantbonificado numeric DEFAULT 0
);


ALTER TABLE public.tblcatfacturadetalle_compra OWNER TO postgres;

--
-- TOC entry 207 (class 1259 OID 18809)
-- Name: tblcatfacturadetalle_compra_intidserie_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatfacturadetalle_compra_intidserie_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatfacturadetalle_compra_intidserie_seq OWNER TO postgres;

--
-- TOC entry 2632 (class 0 OID 0)
-- Dependencies: 207
-- Name: tblcatfacturadetalle_compra_intidserie_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatfacturadetalle_compra_intidserie_seq OWNED BY public.tblcatfacturadetalle_compra.intidserie;


--
-- TOC entry 208 (class 1259 OID 18811)
-- Name: tblcatfacturadetalle_intidserie_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatfacturadetalle_intidserie_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatfacturadetalle_intidserie_seq OWNER TO postgres;

--
-- TOC entry 2633 (class 0 OID 0)
-- Dependencies: 208
-- Name: tblcatfacturadetalle_intidserie_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatfacturadetalle_intidserie_seq OWNED BY public.tblcatfacturadetalle.intidserie;


--
-- TOC entry 209 (class 1259 OID 18813)
-- Name: tblcatfacturaencabezado; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatfacturaencabezado (
    intidserie integer NOT NULL,
    intidcliente integer,
    datfechafactura timestamp without time zone NOT NULL,
    numtasacambio numeric,
    numsubtotal numeric NOT NULL,
    numdescuento numeric NOT NULL,
    numiva numeric NOT NULL,
    numtotal numeric NOT NULL,
    bolanulado boolean DEFAULT false,
    boldevolucion boolean DEFAULT false,
    strusuariocreo character varying(50) NOT NULL,
    datfechacreo timestamp without time zone NOT NULL,
    datfechamodifico timestamp without time zone,
    strusuariomodifico character varying(50),
    strestado character varying(50),
    strtipo character varying(50),
    numerofactura bigint NOT NULL,
    numdescuentovalor numeric,
    numimpuestovalor numeric
);


ALTER TABLE public.tblcatfacturaencabezado OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 18821)
-- Name: tblcatfacturaencabezado_compra; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatfacturaencabezado_compra (
    intidserie integer NOT NULL,
    intidproveedor integer,
    datfechafactura timestamp without time zone NOT NULL,
    numtasacambio numeric,
    numsubtotal numeric NOT NULL,
    numdescuento numeric NOT NULL,
    numiva numeric NOT NULL,
    numtotal numeric NOT NULL,
    bolanulado boolean DEFAULT false,
    boldevolucion boolean DEFAULT false,
    strusuariocreo character varying(50) NOT NULL,
    datfechacreo timestamp without time zone NOT NULL,
    datfechamodifico timestamp without time zone,
    strusuariomodifico character varying(50),
    strestado character varying(50),
    strtipo character varying(50),
    numerofactura bigint NOT NULL
);


ALTER TABLE public.tblcatfacturaencabezado_compra OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 18829)
-- Name: tblcatfacturaencabezado_compra_intidserie_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatfacturaencabezado_compra_intidserie_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatfacturaencabezado_compra_intidserie_seq OWNER TO postgres;

--
-- TOC entry 2634 (class 0 OID 0)
-- Dependencies: 211
-- Name: tblcatfacturaencabezado_compra_intidserie_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatfacturaencabezado_compra_intidserie_seq OWNED BY public.tblcatfacturaencabezado_compra.intidserie;


--
-- TOC entry 212 (class 1259 OID 18831)
-- Name: tblcatfacturaencabezado_intidserie_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatfacturaencabezado_intidserie_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatfacturaencabezado_intidserie_seq OWNER TO postgres;

--
-- TOC entry 2635 (class 0 OID 0)
-- Dependencies: 212
-- Name: tblcatfacturaencabezado_intidserie_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatfacturaencabezado_intidserie_seq OWNED BY public.tblcatfacturaencabezado.intidserie;


--
-- TOC entry 213 (class 1259 OID 18833)
-- Name: tblcatformulariodetalle; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatformulariodetalle (
    idfrm integer,
    idfrmdetalle integer NOT NULL,
    strnombreelemento character varying(50),
    strtipotag character varying(50),
    bolestado boolean DEFAULT false
);


ALTER TABLE public.tblcatformulariodetalle OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 18837)
-- Name: tblcatformulariodetalle_idfrmdetalle_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatformulariodetalle_idfrmdetalle_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatformulariodetalle_idfrmdetalle_seq OWNER TO postgres;

--
-- TOC entry 2636 (class 0 OID 0)
-- Dependencies: 214
-- Name: tblcatformulariodetalle_idfrmdetalle_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatformulariodetalle_idfrmdetalle_seq OWNED BY public.tblcatformulariodetalle.idfrmdetalle;


--
-- TOC entry 215 (class 1259 OID 18839)
-- Name: tblcatformularios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatformularios (
    idfrm integer NOT NULL,
    strformulario character varying(50),
    strnombreform character varying(50),
    bolestado boolean,
    strkeymenu character varying(50)
);


ALTER TABLE public.tblcatformularios OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 18842)
-- Name: tblcatformularios_idfrm_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatformularios_idfrm_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatformularios_idfrm_seq OWNER TO postgres;

--
-- TOC entry 2637 (class 0 OID 0)
-- Dependencies: 216
-- Name: tblcatformularios_idfrm_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatformularios_idfrm_seq OWNED BY public.tblcatformularios.idfrm;


--
-- TOC entry 217 (class 1259 OID 18844)
-- Name: tblcatgastos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatgastos (
    intidclasgasto integer NOT NULL,
    strnombrecategoria character varying(250),
    strusuariocreo character varying(50),
    datfechacreo timestamp without time zone,
    strusuariomodifico character varying(50),
    datfechamodifico timestamp without time zone,
    boolactivo boolean
);


ALTER TABLE public.tblcatgastos OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 18847)
-- Name: tblcatgastos_intidclasgasto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatgastos_intidclasgasto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatgastos_intidclasgasto_seq OWNER TO postgres;

--
-- TOC entry 2638 (class 0 OID 0)
-- Dependencies: 218
-- Name: tblcatgastos_intidclasgasto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatgastos_intidclasgasto_seq OWNED BY public.tblcatgastos.intidclasgasto;


--
-- TOC entry 219 (class 1259 OID 18849)
-- Name: tblcatimpuesto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatimpuesto (
    intidimpuesto integer NOT NULL,
    nombre character varying(50) NOT NULL,
    numvalor numeric NOT NULL,
    bolactivo boolean DEFAULT true
);


ALTER TABLE public.tblcatimpuesto OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 18855)
-- Name: tblcatimpuesto_intidimpuesto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatimpuesto_intidimpuesto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatimpuesto_intidimpuesto_seq OWNER TO postgres;

--
-- TOC entry 2639 (class 0 OID 0)
-- Dependencies: 220
-- Name: tblcatimpuesto_intidimpuesto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatimpuesto_intidimpuesto_seq OWNED BY public.tblcatimpuesto.intidimpuesto;


--
-- TOC entry 221 (class 1259 OID 18857)
-- Name: tblcatingresos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatingresos (
    intidclasingreso integer NOT NULL,
    strnombrecategoria character varying(250),
    strusuariocreo character varying(50),
    datfechacreo timestamp without time zone,
    strusuariomodifico character varying(50),
    datfechamodifico timestamp without time zone,
    boolactivo boolean
);


ALTER TABLE public.tblcatingresos OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 18860)
-- Name: tblcatingresos_intidclasingreso_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatingresos_intidclasingreso_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatingresos_intidclasingreso_seq OWNER TO postgres;

--
-- TOC entry 2640 (class 0 OID 0)
-- Dependencies: 222
-- Name: tblcatingresos_intidclasingreso_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatingresos_intidclasingreso_seq OWNED BY public.tblcatingresos.intidclasingreso;


--
-- TOC entry 223 (class 1259 OID 18862)
-- Name: tblcatmenu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatmenu (
    intidmenu integer NOT NULL,
    strmenu character varying(200),
    strtipomenu character varying(50),
    strnivelmenu character varying(100),
    bolactivo boolean,
    strhref character varying(250),
    strclassicono character varying(250)
);


ALTER TABLE public.tblcatmenu OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 18868)
-- Name: tblcatmenu_intidmenu_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatmenu_intidmenu_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatmenu_intidmenu_seq OWNER TO postgres;

--
-- TOC entry 2641 (class 0 OID 0)
-- Dependencies: 224
-- Name: tblcatmenu_intidmenu_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatmenu_intidmenu_seq OWNED BY public.tblcatmenu.intidmenu;


--
-- TOC entry 225 (class 1259 OID 18870)
-- Name: tblcatmenuperfil; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatmenuperfil (
    intidmenuperfil integer NOT NULL,
    idperfil integer,
    intidmenu integer,
    bolactivo boolean
);


ALTER TABLE public.tblcatmenuperfil OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 18873)
-- Name: tblcatmenuperfil_intidmenuperfil_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatmenuperfil_intidmenuperfil_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatmenuperfil_intidmenuperfil_seq OWNER TO postgres;

--
-- TOC entry 2642 (class 0 OID 0)
-- Dependencies: 226
-- Name: tblcatmenuperfil_intidmenuperfil_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatmenuperfil_intidmenuperfil_seq OWNED BY public.tblcatmenuperfil.intidmenuperfil;


--
-- TOC entry 227 (class 1259 OID 18875)
-- Name: tblcatperfilusr; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatperfilusr (
    idperfil integer NOT NULL,
    strperfil character varying(50),
    bolactivo boolean
);


ALTER TABLE public.tblcatperfilusr OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 18878)
-- Name: tblcatperfilusr_idperfil_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatperfilusr_idperfil_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatperfilusr_idperfil_seq OWNER TO postgres;

--
-- TOC entry 2643 (class 0 OID 0)
-- Dependencies: 228
-- Name: tblcatperfilusr_idperfil_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatperfilusr_idperfil_seq OWNED BY public.tblcatperfilusr.idperfil;


--
-- TOC entry 229 (class 1259 OID 18880)
-- Name: tblcatperfilusrfrm; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatperfilusrfrm (
    idperfilusrfrm integer NOT NULL,
    idfrm integer,
    idperfil integer,
    bolactivo boolean
);


ALTER TABLE public.tblcatperfilusrfrm OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 18883)
-- Name: tblcatperfilusrfrm_idperfilusrfrm_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatperfilusrfrm_idperfilusrfrm_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatperfilusrfrm_idperfilusrfrm_seq OWNER TO postgres;

--
-- TOC entry 2644 (class 0 OID 0)
-- Dependencies: 230
-- Name: tblcatperfilusrfrm_idperfilusrfrm_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatperfilusrfrm_idperfilusrfrm_seq OWNED BY public.tblcatperfilusrfrm.idperfilusrfrm;


--
-- TOC entry 231 (class 1259 OID 18885)
-- Name: tblcatperfilusrfrmdetalle; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatperfilusrfrmdetalle (
    idperfilusrfrmdetalle integer NOT NULL,
    idfrmdetalle integer,
    idperfil integer,
    bolactivo boolean
);


ALTER TABLE public.tblcatperfilusrfrmdetalle OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 18888)
-- Name: tblcatperfilusrfrmdetalle_idperfilusrfrmdetalle_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatperfilusrfrmdetalle_idperfilusrfrmdetalle_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatperfilusrfrmdetalle_idperfilusrfrmdetalle_seq OWNER TO postgres;

--
-- TOC entry 2645 (class 0 OID 0)
-- Dependencies: 232
-- Name: tblcatperfilusrfrmdetalle_idperfilusrfrmdetalle_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatperfilusrfrmdetalle_idperfilusrfrmdetalle_seq OWNED BY public.tblcatperfilusrfrmdetalle.idperfilusrfrmdetalle;


--
-- TOC entry 233 (class 1259 OID 18890)
-- Name: tblcatproductos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatproductos (
    intidproducto integer NOT NULL,
    strnombre character varying(250),
    presentacion character varying(150),
    strdescripcion text,
    strfabricante character varying(250),
    strestado boolean,
    strtipo character varying(250),
    strclasingreso character varying(250),
    numcosto numeric,
    numutilidad numeric,
    numprecioventa numeric,
    bolcontrolinventario boolean,
    intstock integer,
    strimagenproducto text,
    strusuariocreo character varying(50),
    datfechacreo timestamp without time zone,
    strusuariomodifico character varying(50),
    datfechamodifico timestamp without time zone,
    numvigencia integer DEFAULT 0
);


ALTER TABLE public.tblcatproductos OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 18896)
-- Name: tblcatproductos_intidproducto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatproductos_intidproducto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatproductos_intidproducto_seq OWNER TO postgres;

--
-- TOC entry 2646 (class 0 OID 0)
-- Dependencies: 234
-- Name: tblcatproductos_intidproducto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatproductos_intidproducto_seq OWNED BY public.tblcatproductos.intidproducto;


--
-- TOC entry 235 (class 1259 OID 18898)
-- Name: tblcatproveedor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatproveedor (
    intidproveedor integer NOT NULL,
    strnombre_empresa character varying(500),
    strsitioweb_empresa character varying(150),
    strtelefono_empresa character varying(50),
    strdirreccion_empresa text,
    strdepartamento character varying(100),
    strnombre_vendedor character varying(500),
    strcorreo_vendedor character varying(500),
    strtelefono_vendedor character varying(50),
    strusuariocreo character varying(50),
    datfechacreo timestamp without time zone,
    strusuariomodifico character varying(50),
    datfechamodifico timestamp without time zone
);


ALTER TABLE public.tblcatproveedor OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 18904)
-- Name: tblcatproveedor_intidproveedor_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatproveedor_intidproveedor_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatproveedor_intidproveedor_seq OWNER TO postgres;

--
-- TOC entry 2647 (class 0 OID 0)
-- Dependencies: 236
-- Name: tblcatproveedor_intidproveedor_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatproveedor_intidproveedor_seq OWNED BY public.tblcatproveedor.intidproveedor;


--
-- TOC entry 237 (class 1259 OID 18906)
-- Name: tblcattasacambio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcattasacambio (
    id integer NOT NULL,
    fecha date,
    monto numeric
);


ALTER TABLE public.tblcattasacambio OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 18912)
-- Name: tblcattasacambio_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcattasacambio_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcattasacambio_id_seq OWNER TO postgres;

--
-- TOC entry 2648 (class 0 OID 0)
-- Dependencies: 238
-- Name: tblcattasacambio_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcattasacambio_id_seq OWNED BY public.tblcattasacambio.id;


--
-- TOC entry 239 (class 1259 OID 18914)
-- Name: tblcattipofactura; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcattipofactura (
    intid integer NOT NULL,
    tipo character varying(50) NOT NULL,
    boolactivo boolean
);


ALTER TABLE public.tblcattipofactura OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 18917)
-- Name: tblcattipofactura_intid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcattipofactura_intid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcattipofactura_intid_seq OWNER TO postgres;

--
-- TOC entry 2649 (class 0 OID 0)
-- Dependencies: 240
-- Name: tblcattipofactura_intid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcattipofactura_intid_seq OWNED BY public.tblcattipofactura.intid;


--
-- TOC entry 241 (class 1259 OID 18919)
-- Name: tblcattipoproducto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcattipoproducto (
    intidtipoproducto integer NOT NULL,
    strtipo character varying(50),
    bolactivo boolean
);


ALTER TABLE public.tblcattipoproducto OWNER TO postgres;

--
-- TOC entry 242 (class 1259 OID 18922)
-- Name: tblcattipoproducto_intidtipoproducto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcattipoproducto_intidtipoproducto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcattipoproducto_intidtipoproducto_seq OWNER TO postgres;

--
-- TOC entry 2650 (class 0 OID 0)
-- Dependencies: 242
-- Name: tblcattipoproducto_intidtipoproducto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcattipoproducto_intidtipoproducto_seq OWNED BY public.tblcattipoproducto.intidtipoproducto;


--
-- TOC entry 243 (class 1259 OID 18924)
-- Name: tblcatusuario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tblcatusuario (
    intid integer NOT NULL,
    strpnombre character varying(50) NOT NULL,
    strsnombre character varying(50),
    strpapellido character varying(50) NOT NULL,
    strsapellido character varying(50),
    strsexo character varying(50),
    strcorreo character varying(50) NOT NULL,
    stridentificacion character varying(20) NOT NULL,
    strdireccion text NOT NULL,
    strcontacto character varying(100) NOT NULL,
    strusuariocreo character varying(50) NOT NULL,
    datfechacreo timestamp without time zone NOT NULL,
    strusuariomodifico character varying(50),
    datfechamodifico timestamp without time zone,
    datfechabaja date,
    bolactivo boolean DEFAULT true,
    strpassword character varying(50) NOT NULL,
    intidperfil integer
);


ALTER TABLE public.tblcatusuario OWNER TO postgres;

--
-- TOC entry 244 (class 1259 OID 18931)
-- Name: tblcatusuario_intid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tblcatusuario_intid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tblcatusuario_intid_seq OWNER TO postgres;

--
-- TOC entry 2651 (class 0 OID 0)
-- Dependencies: 244
-- Name: tblcatusuario_intid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tblcatusuario_intid_seq OWNED BY public.tblcatusuario.intid;


--
-- TOC entry 245 (class 1259 OID 18933)
-- Name: tbltempfacturadetalle; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbltempfacturadetalle (
    intidserie integer NOT NULL,
    intidproducto integer NOT NULL,
    numcantidad integer NOT NULL,
    strdescripcionproducto character varying(500) NOT NULL,
    numprecioventa numeric NOT NULL,
    numsubttotal numeric NOT NULL,
    numdescuento numeric NOT NULL,
    numtotal numeric NOT NULL,
    strusuariocreo character varying(50) NOT NULL,
    datfechacreo timestamp without time zone NOT NULL,
    numcosto numeric
);


ALTER TABLE public.tbltempfacturadetalle OWNER TO postgres;

--
-- TOC entry 246 (class 1259 OID 18939)
-- Name: tbltempfacturadetalle_compra; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbltempfacturadetalle_compra (
    intidserie integer NOT NULL,
    intidproducto integer NOT NULL,
    numcantidad integer NOT NULL,
    strdescripcionproducto character varying(500) NOT NULL,
    numprecioventa numeric NOT NULL,
    numsubttotal numeric NOT NULL,
    numdescuento numeric NOT NULL,
    numtotal numeric NOT NULL,
    strusuariocreo character varying(50) NOT NULL,
    datfechacreo timestamp without time zone NOT NULL,
    numcantbonificado numeric DEFAULT 0
);


ALTER TABLE public.tbltempfacturadetalle_compra OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 18945)
-- Name: tbltempfacturadetalle_compra_intidserie_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbltempfacturadetalle_compra_intidserie_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbltempfacturadetalle_compra_intidserie_seq OWNER TO postgres;

--
-- TOC entry 2652 (class 0 OID 0)
-- Dependencies: 247
-- Name: tbltempfacturadetalle_compra_intidserie_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbltempfacturadetalle_compra_intidserie_seq OWNED BY public.tbltempfacturadetalle_compra.intidserie;


--
-- TOC entry 248 (class 1259 OID 18947)
-- Name: tbltempfacturadetalle_intidserie_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbltempfacturadetalle_intidserie_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbltempfacturadetalle_intidserie_seq OWNER TO postgres;

--
-- TOC entry 2653 (class 0 OID 0)
-- Dependencies: 248
-- Name: tbltempfacturadetalle_intidserie_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbltempfacturadetalle_intidserie_seq OWNED BY public.tbltempfacturadetalle.intidserie;


--
-- TOC entry 261 (class 1259 OID 27409)
-- Name: tbltrnajuste; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbltrnajuste (
    intserieajuste integer NOT NULL,
    intidproducto integer,
    strmovimiento character varying(250),
    intexistencia integer,
    intcantidadajuste integer,
    intstock integer,
    numcosto numeric,
    numutilidad numeric,
    numprecioventa numeric,
    strusuariocreo character varying(50),
    datfechacreo timestamp without time zone
);


ALTER TABLE public.tbltrnajuste OWNER TO postgres;

--
-- TOC entry 260 (class 1259 OID 27407)
-- Name: tbltrnajuste_intserieajuste_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbltrnajuste_intserieajuste_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbltrnajuste_intserieajuste_seq OWNER TO postgres;

--
-- TOC entry 2654 (class 0 OID 0)
-- Dependencies: 260
-- Name: tbltrnajuste_intserieajuste_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbltrnajuste_intserieajuste_seq OWNED BY public.tbltrnajuste.intserieajuste;


--
-- TOC entry 266 (class 1259 OID 36111)
-- Name: tbltrnajusteinventario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbltrnajusteinventario (
    idreg integer NOT NULL,
    intidcliente integer NOT NULL,
    intidproducto integer NOT NULL,
    intexistencia integer NOT NULL,
    numtotal numeric NOT NULL,
    datfecha date NOT NULL,
    intcantidad integer NOT NULL,
    straplicacosto character varying(2),
    strobservacion text,
    strusuariocreo character varying(50),
    datfechamodifico timestamp without time zone
);


ALTER TABLE public.tbltrnajusteinventario OWNER TO postgres;

--
-- TOC entry 265 (class 1259 OID 36109)
-- Name: tbltrnajusteinventario_idreg_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbltrnajusteinventario_idreg_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbltrnajusteinventario_idreg_seq OWNER TO postgres;

--
-- TOC entry 2655 (class 0 OID 0)
-- Dependencies: 265
-- Name: tbltrnajusteinventario_idreg_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbltrnajusteinventario_idreg_seq OWNED BY public.tbltrnajusteinventario.idreg;


--
-- TOC entry 249 (class 1259 OID 18955)
-- Name: tbltrngastos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbltrngastos (
    intidreggasto integer NOT NULL,
    intidcuenta integer,
    intidclasgasto integer,
    strdescripcion character varying(250),
    nummonto numeric,
    datgasto date,
    datfechacreo timestamp without time zone NOT NULL,
    usuariocreo character varying(50) NOT NULL
);


ALTER TABLE public.tbltrngastos OWNER TO postgres;

--
-- TOC entry 250 (class 1259 OID 18961)
-- Name: tbltrngastos_intidreggasto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbltrngastos_intidreggasto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbltrngastos_intidreggasto_seq OWNER TO postgres;

--
-- TOC entry 2656 (class 0 OID 0)
-- Dependencies: 250
-- Name: tbltrngastos_intidreggasto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbltrngastos_intidreggasto_seq OWNED BY public.tbltrngastos.intidreggasto;


--
-- TOC entry 251 (class 1259 OID 18963)
-- Name: tbltrningresos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbltrningresos (
    intidregingreso integer NOT NULL,
    intidcuenta integer,
    intidclasingreso integer,
    strdescripcion character varying(250),
    nummonto numeric,
    datingreso date,
    datfechacreo timestamp without time zone NOT NULL,
    usuariocreo character varying(50) NOT NULL
);


ALTER TABLE public.tbltrningresos OWNER TO postgres;

--
-- TOC entry 252 (class 1259 OID 18969)
-- Name: tbltrningresos_intidregingreso_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbltrningresos_intidregingreso_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbltrningresos_intidregingreso_seq OWNER TO postgres;

--
-- TOC entry 2657 (class 0 OID 0)
-- Dependencies: 252
-- Name: tbltrningresos_intidregingreso_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbltrningresos_intidregingreso_seq OWNED BY public.tbltrningresos.intidregingreso;


--
-- TOC entry 253 (class 1259 OID 18971)
-- Name: tbltrnmovimientos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbltrnmovimientos (
    intid integer NOT NULL,
    intidcuenta integer NOT NULL,
    numdebito numeric NOT NULL,
    numcredito numeric NOT NULL,
    numsaldo numeric NOT NULL,
    datfechacreo timestamp without time zone NOT NULL,
    usuariocreo character varying(50) NOT NULL,
    numreferencia integer,
    strreferencia character varying(50)
);


ALTER TABLE public.tbltrnmovimientos OWNER TO postgres;

--
-- TOC entry 254 (class 1259 OID 18977)
-- Name: tbltrnmovimientos_intid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbltrnmovimientos_intid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbltrnmovimientos_intid_seq OWNER TO postgres;

--
-- TOC entry 2658 (class 0 OID 0)
-- Dependencies: 254
-- Name: tbltrnmovimientos_intid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbltrnmovimientos_intid_seq OWNED BY public.tbltrnmovimientos.intid;


--
-- TOC entry 255 (class 1259 OID 18979)
-- Name: tbltrnpagos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbltrnpagos (
    intnumdocumento integer NOT NULL,
    numerofactura bigint,
    intserie integer NOT NULL,
    datfecha date NOT NULL,
    intidcliente integer NOT NULL,
    numtotal_cobrado numeric NOT NULL,
    strobservacion text,
    datfechacreo timestamp without time zone NOT NULL,
    strusuariocreo character varying(50) NOT NULL,
    datfechamodifico timestamp without time zone,
    strusuariomodifico character varying(50)
);


ALTER TABLE public.tbltrnpagos OWNER TO postgres;

--
-- TOC entry 268 (class 1259 OID 43831)
-- Name: tbltrnpagos_cxp; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbltrnpagos_cxp (
    intnumdocumento integer NOT NULL,
    numerofactura bigint,
    intserie integer NOT NULL,
    datfecha date NOT NULL,
    intidcliente integer NOT NULL,
    numtotal_cobrado numeric NOT NULL,
    strobservacion text,
    datfechacreo timestamp without time zone NOT NULL,
    strusuariocreo character varying(50) NOT NULL,
    datfechamodifico timestamp without time zone,
    strusuariomodifico character varying(50)
);


ALTER TABLE public.tbltrnpagos_cxp OWNER TO postgres;

--
-- TOC entry 267 (class 1259 OID 43829)
-- Name: tbltrnpagos_cxp_intnumdocumento_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbltrnpagos_cxp_intnumdocumento_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbltrnpagos_cxp_intnumdocumento_seq OWNER TO postgres;

--
-- TOC entry 2659 (class 0 OID 0)
-- Dependencies: 267
-- Name: tbltrnpagos_cxp_intnumdocumento_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbltrnpagos_cxp_intnumdocumento_seq OWNED BY public.tbltrnpagos_cxp.intnumdocumento;


--
-- TOC entry 256 (class 1259 OID 18985)
-- Name: tbltrnregistrocuentas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbltrnregistrocuentas (
    idregistro integer NOT NULL,
    intidcuenta integer NOT NULL,
    numdebe numeric NOT NULL,
    numhaber numeric NOT NULL,
    numsaldo numeric NOT NULL,
    strtipo character varying(50) NOT NULL,
    referencia numeric NOT NULL,
    datfechacreo timestamp without time zone NOT NULL,
    strusariocreo character varying(50) NOT NULL
);


ALTER TABLE public.tbltrnregistrocuentas OWNER TO postgres;

--
-- TOC entry 257 (class 1259 OID 18991)
-- Name: tbltrnregistrocuentas_idregistro_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbltrnregistrocuentas_idregistro_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbltrnregistrocuentas_idregistro_seq OWNER TO postgres;

--
-- TOC entry 2660 (class 0 OID 0)
-- Dependencies: 257
-- Name: tbltrnregistrocuentas_idregistro_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbltrnregistrocuentas_idregistro_seq OWNED BY public.tbltrnregistrocuentas.idregistro;


--
-- TOC entry 258 (class 1259 OID 18993)
-- Name: tbltrntranferencia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbltrntranferencia (
    intidtransferencia integer NOT NULL,
    intidcuentadebitada integer,
    intidcuentaacreditada integer,
    strdescripcion character varying(500),
    datfechattranferencia date,
    nummonto numeric,
    strusuariocreo character varying(50),
    datfechacreo character varying(50),
    bolanulado boolean
);


ALTER TABLE public.tbltrntranferencia OWNER TO postgres;

--
-- TOC entry 259 (class 1259 OID 18999)
-- Name: tbltrntranferencia_intidtransferencia_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbltrntranferencia_intidtransferencia_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbltrntranferencia_intidtransferencia_seq OWNER TO postgres;

--
-- TOC entry 2661 (class 0 OID 0)
-- Dependencies: 259
-- Name: tbltrntranferencia_intidtransferencia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbltrntranferencia_intidtransferencia_seq OWNED BY public.tbltrntranferencia.intidtransferencia;


--
-- TOC entry 2282 (class 2604 OID 19001)
-- Name: tablcatcuentas intidcuenta; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tablcatcuentas ALTER COLUMN intidcuenta SET DEFAULT nextval('public.tablcatcuentas_intidcuenta_seq'::regclass);


--
-- TOC entry 2284 (class 2604 OID 19002)
-- Name: tblcatclientes intidcliente; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatclientes ALTER COLUMN intidcliente SET DEFAULT nextval('public.tblcatclientes_intidcliente_seq'::regclass);


--
-- TOC entry 2285 (class 2604 OID 19003)
-- Name: tblcatdescuento intidimpuesto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatdescuento ALTER COLUMN intidimpuesto SET DEFAULT nextval('public.tblcatdescuento_intidimpuesto_seq'::regclass);


--
-- TOC entry 2287 (class 2604 OID 19004)
-- Name: tblcatexistencia intidserie; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatexistencia ALTER COLUMN intidserie SET DEFAULT nextval('public.tblcatexistencia_intidserie_seq'::regclass);


--
-- TOC entry 2288 (class 2604 OID 19005)
-- Name: tblcatfacturadetalle intidserie; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatfacturadetalle ALTER COLUMN intidserie SET DEFAULT nextval('public.tblcatfacturadetalle_intidserie_seq'::regclass);


--
-- TOC entry 2289 (class 2604 OID 19006)
-- Name: tblcatfacturadetalle_compra intidserie; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatfacturadetalle_compra ALTER COLUMN intidserie SET DEFAULT nextval('public.tblcatfacturadetalle_compra_intidserie_seq'::regclass);


--
-- TOC entry 2293 (class 2604 OID 19007)
-- Name: tblcatfacturaencabezado intidserie; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatfacturaencabezado ALTER COLUMN intidserie SET DEFAULT nextval('public.tblcatfacturaencabezado_intidserie_seq'::regclass);


--
-- TOC entry 2296 (class 2604 OID 19008)
-- Name: tblcatfacturaencabezado_compra intidserie; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatfacturaencabezado_compra ALTER COLUMN intidserie SET DEFAULT nextval('public.tblcatfacturaencabezado_compra_intidserie_seq'::regclass);


--
-- TOC entry 2298 (class 2604 OID 19009)
-- Name: tblcatformulariodetalle idfrmdetalle; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatformulariodetalle ALTER COLUMN idfrmdetalle SET DEFAULT nextval('public.tblcatformulariodetalle_idfrmdetalle_seq'::regclass);


--
-- TOC entry 2299 (class 2604 OID 19010)
-- Name: tblcatformularios idfrm; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatformularios ALTER COLUMN idfrm SET DEFAULT nextval('public.tblcatformularios_idfrm_seq'::regclass);


--
-- TOC entry 2300 (class 2604 OID 19011)
-- Name: tblcatgastos intidclasgasto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatgastos ALTER COLUMN intidclasgasto SET DEFAULT nextval('public.tblcatgastos_intidclasgasto_seq'::regclass);


--
-- TOC entry 2301 (class 2604 OID 19012)
-- Name: tblcatimpuesto intidimpuesto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatimpuesto ALTER COLUMN intidimpuesto SET DEFAULT nextval('public.tblcatimpuesto_intidimpuesto_seq'::regclass);


--
-- TOC entry 2303 (class 2604 OID 19013)
-- Name: tblcatingresos intidclasingreso; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatingresos ALTER COLUMN intidclasingreso SET DEFAULT nextval('public.tblcatingresos_intidclasingreso_seq'::regclass);


--
-- TOC entry 2304 (class 2604 OID 19014)
-- Name: tblcatmenu intidmenu; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatmenu ALTER COLUMN intidmenu SET DEFAULT nextval('public.tblcatmenu_intidmenu_seq'::regclass);


--
-- TOC entry 2305 (class 2604 OID 19015)
-- Name: tblcatmenuperfil intidmenuperfil; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatmenuperfil ALTER COLUMN intidmenuperfil SET DEFAULT nextval('public.tblcatmenuperfil_intidmenuperfil_seq'::regclass);


--
-- TOC entry 2306 (class 2604 OID 19016)
-- Name: tblcatperfilusr idperfil; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatperfilusr ALTER COLUMN idperfil SET DEFAULT nextval('public.tblcatperfilusr_idperfil_seq'::regclass);


--
-- TOC entry 2307 (class 2604 OID 19017)
-- Name: tblcatperfilusrfrm idperfilusrfrm; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatperfilusrfrm ALTER COLUMN idperfilusrfrm SET DEFAULT nextval('public.tblcatperfilusrfrm_idperfilusrfrm_seq'::regclass);


--
-- TOC entry 2308 (class 2604 OID 19018)
-- Name: tblcatperfilusrfrmdetalle idperfilusrfrmdetalle; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatperfilusrfrmdetalle ALTER COLUMN idperfilusrfrmdetalle SET DEFAULT nextval('public.tblcatperfilusrfrmdetalle_idperfilusrfrmdetalle_seq'::regclass);


--
-- TOC entry 2309 (class 2604 OID 19019)
-- Name: tblcatproductos intidproducto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatproductos ALTER COLUMN intidproducto SET DEFAULT nextval('public.tblcatproductos_intidproducto_seq'::regclass);


--
-- TOC entry 2311 (class 2604 OID 19020)
-- Name: tblcatproveedor intidproveedor; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatproveedor ALTER COLUMN intidproveedor SET DEFAULT nextval('public.tblcatproveedor_intidproveedor_seq'::regclass);


--
-- TOC entry 2312 (class 2604 OID 19021)
-- Name: tblcattasacambio id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcattasacambio ALTER COLUMN id SET DEFAULT nextval('public.tblcattasacambio_id_seq'::regclass);


--
-- TOC entry 2313 (class 2604 OID 19022)
-- Name: tblcattipofactura intid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcattipofactura ALTER COLUMN intid SET DEFAULT nextval('public.tblcattipofactura_intid_seq'::regclass);


--
-- TOC entry 2314 (class 2604 OID 19023)
-- Name: tblcattipoproducto intidtipoproducto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcattipoproducto ALTER COLUMN intidtipoproducto SET DEFAULT nextval('public.tblcattipoproducto_intidtipoproducto_seq'::regclass);


--
-- TOC entry 2316 (class 2604 OID 19024)
-- Name: tblcatusuario intid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatusuario ALTER COLUMN intid SET DEFAULT nextval('public.tblcatusuario_intid_seq'::regclass);


--
-- TOC entry 2317 (class 2604 OID 19025)
-- Name: tbltempfacturadetalle intidserie; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltempfacturadetalle ALTER COLUMN intidserie SET DEFAULT nextval('public.tbltempfacturadetalle_intidserie_seq'::regclass);


--
-- TOC entry 2318 (class 2604 OID 19026)
-- Name: tbltempfacturadetalle_compra intidserie; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltempfacturadetalle_compra ALTER COLUMN intidserie SET DEFAULT nextval('public.tbltempfacturadetalle_compra_intidserie_seq'::regclass);


--
-- TOC entry 2325 (class 2604 OID 27412)
-- Name: tbltrnajuste intserieajuste; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrnajuste ALTER COLUMN intserieajuste SET DEFAULT nextval('public.tbltrnajuste_intserieajuste_seq'::regclass);


--
-- TOC entry 2326 (class 2604 OID 36114)
-- Name: tbltrnajusteinventario idreg; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrnajusteinventario ALTER COLUMN idreg SET DEFAULT nextval('public.tbltrnajusteinventario_idreg_seq'::regclass);


--
-- TOC entry 2320 (class 2604 OID 19027)
-- Name: tbltrngastos intidreggasto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrngastos ALTER COLUMN intidreggasto SET DEFAULT nextval('public.tbltrngastos_intidreggasto_seq'::regclass);


--
-- TOC entry 2321 (class 2604 OID 19028)
-- Name: tbltrningresos intidregingreso; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrningresos ALTER COLUMN intidregingreso SET DEFAULT nextval('public.tbltrningresos_intidregingreso_seq'::regclass);


--
-- TOC entry 2322 (class 2604 OID 19029)
-- Name: tbltrnmovimientos intid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrnmovimientos ALTER COLUMN intid SET DEFAULT nextval('public.tbltrnmovimientos_intid_seq'::regclass);


--
-- TOC entry 2327 (class 2604 OID 43834)
-- Name: tbltrnpagos_cxp intnumdocumento; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrnpagos_cxp ALTER COLUMN intnumdocumento SET DEFAULT nextval('public.tbltrnpagos_cxp_intnumdocumento_seq'::regclass);


--
-- TOC entry 2323 (class 2604 OID 19030)
-- Name: tbltrnregistrocuentas idregistro; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrnregistrocuentas ALTER COLUMN idregistro SET DEFAULT nextval('public.tbltrnregistrocuentas_idregistro_seq'::regclass);


--
-- TOC entry 2324 (class 2604 OID 19031)
-- Name: tbltrntranferencia intidtransferencia; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrntranferencia ALTER COLUMN intidtransferencia SET DEFAULT nextval('public.tbltrntranferencia_intidtransferencia_seq'::regclass);


--
-- TOC entry 2552 (class 0 OID 18761)
-- Dependencies: 196
-- Data for Name: hora; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.hora (id, fecha_hora) FROM stdin;
1	2021-05-11 13:22:29.257046
2	2021-05-11 13:24:36.600425
\.


--
-- TOC entry 2553 (class 0 OID 18764)
-- Dependencies: 197
-- Data for Name: tablcatcuentas; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tablcatcuentas (intidcuenta, strnombrecuenta, strrazon, bolactivo, balanceinicial, usuariocreo, datfechacreo)
values (3,	'FONDO FIJO',	'', 't', 0, 'jhonfc9011@hotmail.com',	'2021-05-10 17:59:29.352289-06'),
       (4,	'VENTAS',	'', 't', 1700, 'jhonfc9011@hotmail.com',	'2021-05-10 17:59:29.352289-06'),
	   (6,	'CUENTAS POR PAGAR',	'', 't', 763.60, 'jhonfc9011@hotmail.com', '2021-05-10 17:59:29.352289-06'),
       (5,	'CUENTAS X COBRAR CLIENTES',	'', 't', 120.00, 'jhonfc9011@hotmail.com', '2021-05-10 17:59:29.352289-06'),
	   (2,	'CAJA CHICA',	'', 't', 7999.67, 'jhonfc9011@hotmail.com', '2021-05-10 17:59:29.352289-06')
\.


--
-- TOC entry 2555 (class 0 OID 18772)
-- Dependencies: 199
-- Data for Name: tblcatclientes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatclientes (intidcliente, bigcodcliente, strpnombre, strsnombre, strpapellido, strsapellido, strsexo, stridentificacion, strcorreo, strtelefono, strcontacto, strfechadenacimiento, strdireccion, intaltura, intpeso, strgymanterior, intanioentrenando, strimagen, strusuariocreo, datfechacreo, strusuariomodifico, datfechamodifico, bolactivo) FROM stdin;
262	1620748171	KENLEY	JOSUE	GAITAN		MASCULINO		sincorreos@gym.com	58083149		2021-05-11	 	0	0		0		jhonfc9011@hotmail.com	2021-05-11 15:52:02.705195	\N	\N	t
163	7	ALEX   		  VARGAS   		MASCULINO			  83222011 		2021-04-26		0	0		0	\N	\N	\N	RPRAVIA	2021-05-11 17:37:08.558462	t
267	1620749968	WALTER 		LÓPEZ		MASCULINO	001-140795-1003S	sincorreos@gym.com	84037115		1995-07-14	 	0	0		0		VBONILLA	2021-05-11 16:20:31.724265	RPRAVIA	2021-05-11 17:57:19.275638	t
272	1621095796	JERSON 		HERNáNDEZ		MASCULINO		sincorreo@gym.com	59939112		1995-10-26	 	0	0		0		RPRAVIA	2021-05-15 11:25:05.422462	\N	\N	t
263	1620748917	JOSELING		MARTÍNEZ	GUTIÉRREZ	FEMENINO	409-280599-1000F	sincorreos@gym.com	85662416		1999-05-28	 	0	0		0		VBONILLA	2021-05-11 16:05:30.513175	RPRAVIA	2021-05-11 17:56:57.289607	t
268	1620873094	STALIN		ROBLES		MASCULINO	001-300576-0065X	sincorreo@gym.com	88072934		1976-05-30	 	0	0		0		VBONILLA	2021-05-12 20:36:24.620523	\N	\N	t
273	1621099898	GERSON		HERNÁNDEZ		MASCULINO		sincorreos@gym.com	59939112		1999-10-26	 	0	0		0		VBONILLA	2021-05-15 11:34:02.088663	\N	\N	t
264	1620749359	ISMAEL	ISAAC	BORGE	CALERO	MASCULINO	000-090104-00000	sincorreos@gym.com	00000000		2004-01-09	 	0	0		0		VBONILLA	2021-05-11 16:10:26.285426	\N	\N	t
269	1621095210	JERSON 		HERNáNDEZ		MASCULINO			59939112		1995-10-26	 	0	0		0		RPRAVIA	2021-05-15 11:18:18.474784	\N	\N	t
274	1621279995	ALLISON	JUDITH	HUERTAS		FEMENINO		notienecorreo@mail.com	75450572		1995-11-12	 	0	0		0		RPRAVIA	2021-05-17 14:37:08.83999	\N	\N	t
265	1620749546	ISABEL 		MAIRENA	DELGADO	FEMENINO	241-080389-0008	sincorreos@gym.com	87364906		1989-03-08	 	0	0		0		VBONILLA	2021-05-11 16:12:56.971205	RPRAVIA	2021-05-11 17:55:49.832752	t
270	1621095645	JERSON 		HERNáNDEZ		MASCULINO			59939112		1995-10-26	 	0	0		0		RPRAVIA	2021-05-15 11:21:04.906469	\N	\N	t
275	1621281216	KATHYA		ROCHA	GALO	FEMENINO		notienecorreo@mail.com	75450572		1998-02-23	 	0	0		0		RPRAVIA	2021-05-17 14:55:21.549689	\N	\N	t
164	11	ALEXANDER   	\N	  GONZALEZ   	\N	\N	\N	\N	  88330653 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
165	14	ANA   	\N	  HERNÁNDEZ   	\N	\N	\N	\N	  81061465 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
166	20	ASHLEY   	\N	  OBANDO   	\N	\N	\N	\N	  75058464 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
167	24	CARLOS   	\N	  CANO   	\N	\N	\N	\N	  81063849 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
168	34	CESAR   	\N	  LÓPEZ   	\N	\N	\N	\N	  57634250 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
169	40	DARLEN   	\N	  CALERO   	\N	\N	\N	\N	  5754-3625 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
170	45	DEYKELL   	\N	  DELGADILLO   	\N	\N	\N	\N	  84141525 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
171	48	EDGAR   	\N	  HERRERA   	\N	\N	\N	\N	  89559011 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
172	63	FAUSTO   	\N	  TERCERO   	\N	\N	\N	\N	  76977390 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
173	66	FRANCISCO   	\N	  MENDIETA   	\N	\N	\N	\N	  88978429 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
205	33	CECILIA   	\N	  PALACIOS   	\N	\N	\N	\N	\N	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
174	67	FRANCISCO   	\N	  OBANDO   	\N	\N	\N	\N	  82120437 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
175	68	GABRIEL   	\N	  ALEJANDRO GARCÍA   	\N	\N	\N	\N	  77864859 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
176	76	HANIA   	\N	  CANTARERO   	\N	\N	\N	\N	  57336625 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
177	87	JEFRI   	\N	  DOMÍNGUEZ   	\N	\N	\N	\N	  57792281 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
178	90	JEYMI   	\N	  DÍAZ   	\N	\N	\N	\N	  76980598 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
179	91	JIM   	\N	  ROMERO   	\N	\N	\N	\N	  83351907 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
180	99	JOSÉ   	\N	  GAITÁN   	\N	\N	\N	\N	  57751100 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
181	101	JOSÉ   	\N	  LUIS   	\N	\N	\N	\N	  58083149 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
182	108	KARLA   	\N	  GUTIÉRREZ   	\N	\N	\N	\N	  77256318 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
183	114	KENNETH   	\N	  DÍAZ   	\N	\N	\N	\N	  75097309 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
184	117	KEVIN   	\N	  CARDOZA   	\N	\N	\N	\N	  - 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
185	121	LEONORA   	\N	  MAYORGA   	\N	\N	\N	\N	  82368226 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
186	126	MAGALY   	\N	  MEDRANO   	\N	\N	\N	\N	  86880592 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
187	128	MARCELO   	\N	  QUINTANA   	\N	\N	\N	\N	  78441677 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
212	185	SANDRA   	\N	  DELGADILLO   	\N	\N	\N	\N	\N	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
213	197	VALESKA   	\N	  MERCADO   	\N	\N	\N	\N	\N	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
214	200	VERONICA   	\N	  ALICIA LACAYO   	\N	\N	\N	\N	\N	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
202	207	WEBSTER   	\N	  MUÑOZ   	\N	\N	\N	\N	  88219956 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
203	216	YURISA   	\N	  CAMPOS   	\N	\N	\N	\N	  89879772 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
19	23	BRYAN   	\N	  AYERDIS   	\N	\N	  001-181994-0001Q   	\N	  76794062 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
20	25	CARLOS   	\N	  GARCÍA   	\N	\N	  001-211174-004b   	\N	  76608299 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
21	26	CARLOS   	\N	  GUEVARA   	\N	\N	  042-140298-0000K   	\N	  85161458 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
22	27	CARLOS   	\N	  SARAVIA   	\N	\N	  361-250790-0000P   	\N	  81289641 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
23	28	CARLOS   	\N	  URTECHO   	\N	\N	  001-201282-0015J   	\N	  83615220 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
24	29	CARLOS   	\N	  VALVERDE   	\N	\N	  001-190103-1018F   	\N	  75373788 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
25	30	CARMEN   	\N	  DÁVILA   	\N	\N	  001-290178-0021U   	\N	  85501198 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
26	31	CAROLINA   	\N	  MEDINA   	\N	\N	  001-131001-1030A   	\N	  81346598 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
27	32	CAROLINA   	\N	  RIVAS   	\N	\N	  001-170785-0050S   	\N	  86166008 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
28	35	CHRISTIAN   	\N	  CANO   	\N	\N	  001-160184-0032M   	\N	  8335-1907 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
29	37	CRISTEL   	\N	  HURTADO   	\N	\N	  001-040581-0074Y   	\N	  78265159 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
30	38	DANIEL   	\N	  GAITÁN   	\N	\N	  365-010490-0000M   	\N	  81003838 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
31	39	DANIELA   	\N	  GONZALEZ   	\N	\N	  001-051194-0014E   	\N	  87370722 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
32	41	DARLEN   	\N	  MARTÍNEZ   	\N	\N	  001-230191-0056Q   	\N	  87784391 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
33	43	DEAN   	\N	  CAMPBELL   	\N	\N	  001-041203-1015R   	\N	  88145806 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
34	44	DEXTER   	\N	  CARTER   	\N	\N	  601-171281-0000C   	\N	  87821225 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
35	47	EDDY   	\N	  TORRES   	\N	\N	  001-160488-0009K   	\N	  77786812 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
36	49	EDSON   	\N	  BONILLA   	\N	\N	  001-271294-0011F   	\N	  75466856 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
37	50	EDSON   	\N	  LEAL   	\N	\N	  001-161191-0030M   	\N	  88176324 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
38	51	ELIZABETH   	\N	  RAMOS   	\N	\N	  001-150599-1056S   	\N	  76478966 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
39	52	ELLIETE   	\N	  GARCÍA   	\N	\N	  001-150599-1056S   	\N	  76478966 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
40	53	ELLIETE   	\N	  SILVA   	\N	\N	  001-180601-1027G   	\N	  82948862 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
41	54	EMILYN   	\N	  GÓMEZ   	\N	\N	  001-030195-0001Q   	\N	  77201035 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
42	55	ENRIQUE   	\N	  TAYLOR   	\N	\N	  001-140791-0017S   	\N	  87891924 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
43	57	ERICK   	\N	  ROJAS   	\N	\N	  001-251079-0029P   	\N	  77448802 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
44	58	ERIKA   	\N	  RUBIO   	\N	\N	  007-260893-0000A   	\N	  78414915 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
45	59	ERNESTO   	\N	  LACAYO   	\N	\N	  001-200495-0047W   	\N	  81580911 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
46	61	ESTEBAN   	\N	  ORTÍZ   	\N	\N	  561-230896-0006E   	\N	  82822901 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
47	62	EVELIN   	\N	  DELGADILLO   	\N	\N	  001-041202-1057S   	\N	  76205475 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
48	64	FERNANDA   	\N	  ROJAS   	\N	\N	  561-220293-1000Y   	\N	  58444324 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
49	65	FERNANDO   	\N	  CASTILLO   	\N	\N	  001-221195-0006C   	\N	  76162383 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
50	69	GABRIELA   	\N	  RAMÍREZ   	\N	\N	  001-070801-1028W   	\N	  84522644 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
51	70	GIANA   	\N	  OMEIR   	\N	\N	  001-060703-1035K   	\N	  87520164 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
52	71	GIOVANNY   	\N	  MERCADO   	\N	\N	  001-280592-0058Y   	\N	  85530870 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
53	72	GLADYS   	\N	  JARQUÍN   	\N	\N	  601-050595-001F   	\N	  85089628 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
54	73	GLENDA   	\N	  PEÑA   	\N	\N	  001-170191-0008A   	\N	  89592091 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
55	74	GLENDYS   	\N	  CARRERO   	\N	\N	  450-230969-0001L   	\N	  87539491 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
56	75	GRETEL   	\N	  CHAMORRO   	\N	\N	  001-010500-1024Q   	\N	  75365665 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
57	77	HANIEL   	\N	  GUITIERREZ   	\N	\N	  001-151197-0024V   	\N	  84120323 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
58	78	HAZEL   	\N	  CRUZ   	\N	\N	  001-290492-0013B   	\N	  78562947 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
59	79	HEYDI   	\N	  RUIZ   	\N	\N	  481-141078-0003Q   	\N	  83958207 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
60	80	ILISH   	\N	  ARGÜELLO   	\N	\N	  001-220296-0014W   	\N	  77196706 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
61	81	ISAAC   	\N	  JARA   	\N	\N	  005.161088-0000J   	\N	  82646433 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
62	82	JADER   	\N	  VANEGAS   	\N	\N	  001-020585-0064M   	\N	  77340424 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
63	83	JAMILETH   	\N	  CARRILLO   	\N	\N	  001-041295-0034A   	\N	  87410941 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
64	84	JAQUELINE   	\N	  TREMINIO   	\N	\N	  001-100785-3900Q   	\N	  78400659 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
65	86	JEANINA   	\N	  TORUÑO   	\N	\N	  001-060198-0005K   	\N	  87525743 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
66	88	JESSENIA   	\N	  LÓPEZ   	\N	\N	  001-230796-0053Y   	\N	  77562506 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
67	89	JESSICA   	\N	  HUNTER   	\N	\N	  201-120289-0010M   	\N	  88205967 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
68	92	JIMY   	\N	  RIVAS PILARTE   	\N	\N	  001-250286-0013G   	\N	  76688755 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
69	93	JOAN   	\N	  SÁNCHEZ   	\N	\N	  001-290400-1022S   	\N	  76217126 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
70	94	JOHANNA   	\N	  LOGO   	\N	\N	  001-240794-0050J   	\N	  75169604 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
71	95	JOLIETH   	\N	  MÉNDEZ   	\N	\N	  001-040398-0002Q   	\N	  89053542 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
72	96	JONATHAN   	\N	  CASTILLO   	\N	\N	  001-261087-0028W   	\N	  81432049 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
73	97	JORGE   	\N	  GÓMEZ   	\N	\N	  001-071091-0014T   	\N	  89930469 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
74	98	JORGE   	\N	  SALDERO   	\N	\N	  001-190396-0040A   	\N	  81648651 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
75	100	JOSÉ   	\N	  HUETA   	\N	\N	  001-150775-0098U   	\N	  87201281 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
76	103	JOSNLLY   	\N	  CAROLINA ROCHA   	\N	\N	  001-050881-0046Q   	\N	  75071394 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
77	104	JOURLEN   	\N	  LÓPEZ   	\N	\N	  409-280599-1000F   	\N	  85662416 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
83	111	KATHERINE   	\N	  RÍOS   	\N	\N	  042-160591-001E   	\N	  87330840 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
84	112	KELVIN   	\N	  SOLÍS   	\N	\N	  001-070796-0006N   	\N	  83931403 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
85	113	KENIA   	\N	  MALDONADO   	\N	\N	  001-220596-0042W   	\N	  85853443 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
86	115	KENNETH   	\N	  ZAPATA   	\N	\N	  042-120985-0005J   	\N	  85275855 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
87	116	KERTYN   	\N	  PADILLA   	\N	\N	  001-030886-0020F   	\N	  87745540 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
88	118	KEVIN   	\N	  GARCÍA   	\N	\N	  001-101299-1057D   	\N	  84592640 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
89	119	KUHNEESHA   	\N	  CAMPBELL   	\N	\N	  001-050494-0067R   	\N	  84783610 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
90	120	LEONARDO   	\N	  PAREDES   	\N	\N	  001-190995-0080N   	\N	  83271019 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
91	122	LESTHER   	\N	  GRANADOS   	\N	\N	  081-080899-1001D   	\N	  88862350 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
92	123	LISETH   	\N	  ARCIAS   	\N	\N	  084-240169-0006B   	\N	  87703421 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
93	124	LUIS   	\N	  CARRIÓN   	\N	\N	  001-020381-0056M   	\N	  84836068 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
94	127	MAGDALENA   	\N	  VILLANUEVA   	\N	\N	  001-261285-0066M   	\N	  88479947 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
95	129	MARGARITA   	\N	  ROJAS   	\N	\N	  001-230686-0074U   	\N	  86718887 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
96	131	MARIA   	\N	  GABRIELA GUEVARA   	\N	\N	  001-220896-0047W   	\N	  82488216 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
97	133	MARÍA   	\N	  JOSÉ RAMIREZ   	\N	\N	  001-080891-0012F   	\N	  85504732 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
98	136	MARIO   	\N	  VARGAS   	\N	\N	  001-260163-0002Q   	\N	  77426976 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
2	2	AARON   	\N	  DÍAZ   	\N	\N	  001-181199-1009M   	\N	  58536925 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
3	3	ABNER   	\N	  VILLALTA   	\N	\N	  001-240275-0042V   	\N	  88877428 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
4	4	ALDAIR   	\N	  CARBALLO   	\N	\N	  001-281001-1005F   	\N	  87747841 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
5	5	ALEJANDRA   	\N	  VARGAS   	\N	\N	  001-110690-0024S   	\N	  88400270 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
6	6	ALEJANDRO   	\N	  CISNEROS   	\N	\N	  001-060990-0051F   	\N	  87584974 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
7	8	ALEXA   	\N	  GONZALEZ   	\N	\N	  441-010799-1015H   	\N	  88999748 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
8	9	ALEXANDER   	\N	  BORGE   	\N	\N	  001-250477-0004J   	\N	  84127272 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
9	10	ALEXANDER   	\N	  CARRIÓN   	\N	\N	  001-151101-1043A   	\N	  58131527 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
10	12	ALEXIS   	\N	  VALLE   	\N	\N	  610-260697-0011D   	\N	  89145263 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
11	13	ANA   	\N	  CARRILLO   	\N	\N	  001-170676-0052M   	\N	  87791085 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
12	15	ANDRÉS   	\N	  MIRANDA   	\N	\N	  001-280698-0012X   	\N	  57732954 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
13	16	ANDY   	\N	  RUIZ   	\N	\N	  001-011201-1033U   	\N	  75143907 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
14	17	ARABELLA   	\N	  CARRERO   	\N	\N	  291-250393-0001F   	\N	  85469393 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
15	18	ARLEN   	\N	  LÓPEZ   	\N	\N	  001-030884-0015L   	\N	  84632925 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
16	19	ARMANDO   	\N	  SÁNCHEZ   	\N	\N	  001-030477-0022F   	\N	  86567777 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
17	21	AURA   	\N	  CASTILLO   	\N	\N	  288-180193-0000Y   	\N	  83309861 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
18	22	AZARELLA   	\N	  JUÁREZ   	\N	\N	  001-120184-0031C   	\N	  76341812 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
99	137	MARISOL   	\N	  BRAVO   	\N	\N	  001-151288-0020W   	\N	  77966718 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
100	138	MARLON   	\N	  SÁNCHEZ   	\N	\N	  001-140601-1045S   	\N	  76757124 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
101	139	MARVIN   	\N	  JIMÉNEZ   	\N	\N	  001-160589-0045A   	\N	  76214243 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
102	140	MARYURI   	\N	  MÉNDEZ   	\N	\N	  001-020695-0055E   	\N	  57845043 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
103	141	MAYCOL   	\N	  CRUZ   	\N	\N	  001-010692-0015A   	\N	  84179896 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
104	142	MAYNOR   	\N	  MARADIAGA   	\N	\N	  001-290486-0036D   	\N	  89919724 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
105	143	MERCEDES   	\N	  GUTIERREZ   	\N	\N	  001-280688-0028Y   	\N	  77209247 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
110	149	NATHALIE   	\N	  VANEGAS   	\N	\N	  001-140390-0025F   	\N	  86617874 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
111	150	NATHASHA   	\N	  RAMOS   	\N	\N	  001-070895-0026W   	\N	  89368655 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
112	151	NELSON   	\N	  ÁLVAREZ   	\N	\N	  001-190800-1043U   	\N	  76474456 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
113	152	NICKY   	\N	  ARTEAGA   	\N	\N	  001-140902-1034U   	\N	  82914491 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
114	153	NICOLE   	\N	  ATENCIO   	\N	\N	  001-100669-0065G   	\N	  87895019 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
115	154	NICOLE   	\N	  GUEVARA   	\N	\N	  001-191281-0077F   	\N	  84511454 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
116	155	NOE   	\N	  MARTÍNEZ   	\N	\N	  888-100394-0000Y   	\N	  75440489 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
117	156	NOE   	\N	  REYES   	\N	\N	  001-150301-1005G   	\N	  89304909 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
118	158	NORMA   	\N	  GUEVARA   	\N	\N	  001-170188-0018Y   	\N	  83963289 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
119	159	NORMAN   	\N	  AGUILAR   	\N	\N	  001-041285-0031b   	\N	  83242696 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
120	160	OCTAVIO   	\N	  VILLALTA   	\N	\N	  121-220596-0038S   	\N	  85607658 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
121	161	OLGA   	\N	  LÓPEZ   	\N	\N	  001-160482-0034U   	\N	  76494508 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
122	162	OMAR   	\N	  MERCEDES   	\N	\N	  001-281194-0008X   	\N	  85229761 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
123	163	ORLANDO   	\N	  AMAYA   	\N	\N	  001-250165-0010L   	\N	  82496539 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
124	165	OSMAR   	\N	  HURTADO   	\N	\N	  001-190492-0012X   	\N	  86052683 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
125	166	PAHOLA   	\N	  SÁNCHEZ   	\N	\N	  001-210793-0016V   	\N	  58332379 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
126	167	PATRICIA   	\N	  VALLE   	\N	\N	  001-121196-1004K   	\N	  82434501 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
127	169	RACHELL   	\N	  DELGADILLO   	\N	\N	  001-170390-0035X   	\N	  85630245 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
128	170	RAFAEL   	\N	  JIMÉNEZ   	\N	\N	  001-260499-1012M   	\N	  78170703 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
129	174	RICHARD   	\N	  ARANA   	\N	\N	  888-210499-1000P   	\N	  77781512 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
130	175	RINA   	\N	  HERNÁNDEZ   	\N	\N	  001-110879-0064J   	\N	  76166622 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
131	176	ROBERTO   	\N	  CASTILLO   	\N	\N	  001-191190-0055E   	\N	  85831403 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
132	177	RODOLFO   	\N	  TELLEZ   	\N	\N	  001-090686-0047K   	\N	  88657602 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
133	178	ROMEL   	\N	  MONTENEGRO   	\N	\N	  001-230104-1026S   	\N	  75250376 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
134	179	RONALD   	\N	  REYES   	\N	\N	  001-020595-0014D   	\N	  81710122 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
135	180	ROSA   	\N	  CÁCERES   	\N	\N	  001-041094-0039X   	\N	  85776605 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
136	181	ROSA   	\N	  MORALES   	\N	\N	  001-061088-0047T   	\N	  87391774 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
137	182	RUTH   	\N	  AGUILAR   	\N	\N	  001-300867-0034A   	\N	  89785752 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
138	183	SAMUEL   	\N	  DELGADO   	\N	\N	  001-290867-0018M   	\N	  76117635 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
139	184	SANDRA   	\N	  CHÁVEZ   	\N	\N	  001-160399-1045U   	\N	  87471031 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
140	186	SANDRA   	\N	  MORALES   	\N	\N	  161-161086-0007   	\N	  57741328 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
141	187	SANDRA   	\N	  SÁNCHEZ   	\N	\N	  567-300388-0000S   	\N	  57866743 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
142	188	SARDES   	\N	  PÉREZ   	\N	\N	  001-131277-0014V   	\N	  57582906 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
143	190	SHEYNON   	\N	  SALOMÓN   	\N	\N	  447-281077-0000G   	\N	  88345964 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
144	193	STEVEN   	\N	  GARCÍA   	\N	\N	  610-060302-1000S   	\N	  89094960 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
145	194	TATIANA   	\N	  ROJAS   	\N	\N	  001-300576-0065X   	\N	  88072934 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
146	195	THELMA   	\N	  SÁNCHEZ   	\N	\N	  001-160602-1047T    	\N	  78164268 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
147	196	VALENTINA   	\N	  CARRIÓN   	\N	\N	  001-190303-0021A   	\N	  81064568 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
148	199	VERONICA   	\N	  AGUILAR   	\N	\N	  001-260198-0006E   	\N	  85904569 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
149	201	VERONICA   	\N	  OBANDO   	\N	\N	  001-290697-0022R   	\N	  83209955 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
150	202	VIDAL   	\N	  ROMERO   	\N	\N	  281-091187-0001G   	\N	  17863762780 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
151	204	WALKIRIA   	\N	  OBANDO   	\N	\N	  001-100492-0025S   	\N	  89778303 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
152	205	WALTER   	\N	  CELEBERTTY   	\N	\N	  001-050486-0022L   	\N	  87032222 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
153	206	WALTER   	\N	  GAITÁN   	\N	\N	  001-201087-0021B   	\N	  75058464 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
154	208	WENDELL   	\N	  CORTÉS   	\N	\N	  001-071098-1020Y   	\N	  86013821 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
155	209	WILLIAM   	\N	  MONTENEGRO   	\N	\N	  001-290388-0027B   	\N	  88755454 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
156	210	YADER   	\N	  MARTÍNEZ   	\N	\N	  001-290799-1019V   	\N	  77012664 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
157	211	YAHAIRA   	\N	  MATUTE   	\N	\N	  001-030892-0012P   	\N	  75089416 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
158	212	YAJAIRA   	\N	  SABALLOS   	\N	\N	  001-140586-0011A   	\N	  81670465 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
159	213	YAOSKA   	\N	  JARQUÍN   	\N	\N	  001-130396-0005Y   	\N	  84511638 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
160	214	YENNSLY   	\N	  ROCHA   	\N	\N	  001-280493-0005E   	\N	  84422377 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
161	215	YONDRA   	\N	  IBARRA   	\N	\N	  001-130785-0031Y   	\N	  85488905 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
162	218	YURISA    	\N	  CAMPOS   	\N	\N	  001-280800-1029Y   	\N	  88171299 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
78	105	JULIO   	\N	  ROMERO LUNA   	\N	\N	  001-200300-1025U   	\N	  81108357 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
79	106	KARINA   	\N	  MARTÍNEZ   	\N	\N	  443-280892-0000S   	\N	  87178544 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
80	107	KARLA CAROLINA   	\N	  ROMERO VEGA   	\N	\N	  001-200288-0015M   	\N	  89066412 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
81	109	KARLA   	\N	  OLIVARES   	\N	\N	  001-210890-0067Y   	\N	  86925083 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
82	110	KATHERINE   	\N	  MONTOYA   	\N	\N	  001-171097-0002U   	\N	  88604682 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
204	1	AARON   		  BORGE   		MASCULINO					2021-04-26		0	0		0	\N	\N	\N	jhonfc9011@hotmail.com	2021-04-26 16:22:29.748011	t
188	130	MARÍA   	\N	  FERNANDA VADO   	\N	\N	\N	\N	  88136026 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
189	132	MARÍA JOSÉ   	\N	  GUTIERREZ   	\N	\N	\N	\N	  78406113 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
190	134	MARINA   	\N	  LÓPEZ   	\N	\N	\N	\N	  83207040 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
191	135	MARIO   	\N	  NUÑEZ   	\N	\N	\N	\N	  77297020 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
192	157	NOELIA   	\N	  PALACIOS   	\N	\N	\N	\N	  88832634 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
193	164	OSMAN   	\N	  ZAMORA   	\N	\N	\N	\N	  57207380 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
194	168	PETER   	\N	  ALONZO ARAGÓN   	\N	\N	\N	\N	  77011441 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
195	171	RAMIRO   	\N	  LOAISIGA   	\N	\N	\N	\N	  89114455 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
196	172	REINOLDS   	\N	  SPERBENG   	\N	\N	\N	\N	  87318513 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
197	173	RICARDO   	\N	  BARRIOS   	\N	\N	\N	\N	  77782906 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
198	189	SCARLETE   	\N	  JOSEPH   	\N	\N	\N	\N	  88685749 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
199	191	SILGIA   	\N	  VALLE   	\N	\N	\N	\N	  87487282 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
200	198	VARIOS   	\N	  VARIOS   	\N	\N	\N	\N	  78251311 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
201	203	VILMA   	\N	  BONILLA   	\N	\N	\N	\N	  76205349 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
206	36	CHRISTIAN   	\N	  SOLANO   	\N	\N	\N	\N	\N	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
207	42	DAVID   	\N	  ALVARADO   	\N	\N	\N	\N	\N	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
208	46	EDDY   	\N	  RIVAS   	\N	\N	\N	\N	\N	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
209	56	ERICK   	\N	  ESTRADA   	\N	\N	\N	\N	\N	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
210	60	ERUBIEL   	\N	  REYES   	\N	\N	\N	\N	\N	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
211	148	NAHOBI   	\N	  GAITÁN   	\N	\N	\N	\N	\N	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
106	144	MEYLING   	\N	  ANDINO   	\N	\N	  001-190989-0022H   	\N	  84038211 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
107	145	MICHAEL   	\N	  ONILL   	\N	\N	  001-080966-0052R   	\N	  8760-9235 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
108	146	MOISES   	\N	  BORGE   	\N	\N	  291-191187-0001C   	\N	  88980339 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
109	147	MOISÉS   	\N	  PADILLA   	\N	\N	  001-010590-0015E   	\N	  82617011 	\N	2021-04-26	\N	0	0	\N	0	\N	\N	\N	\N	\N	t
217	219	ASHLEY	\N	PADILLA	\N	\N	604-311002-1000W	\N	78546579	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
218	220	CARLOS	\N	OROZCO	\N	\N	-	\N	75002594	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
219	221	DIEGO	\N	CENTENO	\N	\N	001-200497-0063Y	\N	84561152	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
220	222	GRACE	\N	LÓPEZ	\N	\N	281-060978-0028S	\N	88153025	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
221	223	GRACIELA	\N	FARRACH	\N	\N	001-101002-1051L	\N	8144-8525	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
222	224	GYMNER	\N	CHAMORRO	\N	\N	001-231102-1010B	\N	57902087	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
223	225	HAROL	\N	CUADRA	\N	\N	001-221183-0070N	\N	75561779/ 78938775	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
224	226	JAQUELINE	\N	QUINTANILLA	\N	\N	001-300879-0031P	\N	89413952	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
225	227	JAVIER	\N	GAITÁN	\N	\N	001-270481-0058A	\N	57598320	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
226	228	MANUEL	\N	VALLE	\N	\N	001-180595-0017R	\N	89730326	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
227	229	MARLON	\N	JUAREZ	\N	\N	-	\N	89710546	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
228	230	NOE	\N	MARTÍNEZ	\N	\N	-	\N	88832634	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
229	231	REBECCA	\N	PALACIOS	\N	\N	001-080894-0036Q	\N	58869688	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
230	232	REINA	\N	CANTARERO	\N	\N	001-120893-0002S	\N	87986530	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
231	233	STEPHANIE	\N	RAMOS	\N	\N	001-090195-0013E	\N	87810645	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
232	234	WILMER	\N	OPORTA	\N	\N	001-301295-0005A	\N	77063807	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
233	235	YADER	\N	JARQUÍN	\N	\N	001-190596-0034G	\N	84880725	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
234	236	YASSER	\N	AVENDAÑO	\N	\N	001-231296-0036N	\N	77225031	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
249	248	KATHERINE	MASSIEL	ESTRADA	AYERDIS	\N	NULL	\N	NULL	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
256	255	RICARDO	MANUEL	BENARD	ZAKERS	\N	601-310582-0000g	\N	85051396	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
257	256	SASHA	MISHELLY	BENARD	ZAKERS	\N	601-120388-0000U	\N	86510851	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
261	261	JUAN	PABLO	OROZCO	GARCÍA	\N	001-011002-1021L	\N	85563801	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
266	1620749879	RAMIRO 		BALDIZóN		MASCULINO	001-090989-0039	sincorreos@gym.com	83911093		1989-09-09	 	0	0		0		VBONILLA	2021-05-11 16:18:28.269494	\N	\N	t
238	237	ANA	RAFELA	MEJÍA	\N	\N	001-240990-0020L	\N	81001242	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
239	238	ANGELA	LUCÍA	MIRANDA	\N	\N	001-250988-0037S	\N	89028804	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
243	242	EYMI	LÓPEZ	CRUZ	\N	\N	-	\N	87744063	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
244	243	FERNANDO	ALFREDO	MELÉNDEZ	\N	\N	39071	\N	81177283	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
245	244	HARVIN	ALEJANDRO	RODRIGUEZ	\N	\N	241-130398-1000T	\N	85618505	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
246	245	JESSICA	DÍAZ	LÓPEZ	\N	\N	-	\N	87745539	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
247	246	JOSÉ	LUIS	FUENTES	\N	\N	NULL	\N	82707054	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
248	247	KATERINE	HERNANDES	RIVERA	\N	\N	001-021287-0016V	\N	NULL	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
252	251	MARÍA	JOSÉ	ACOSTA	\N	\N	001-190389-0010T	\N	58636120	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
271	1621095653	JERSON 		HERNáNDEZ		MASCULINO			59939112		1995-10-26	 	0	0		0		RPRAVIA	2021-05-15 11:21:45.448967	\N	\N	t
276	1621376218	JOHNY		FONSECA	ARRIETA	MASCULINO			83924927	sincorreos@gym.com	1989-01-01	 	0	0		0		RPRAVIA	2021-05-18 17:20:25.260539	\N	\N	t
253	252	MATILDE	OCAMPO	HERNANDES	\N	\N	40004	\N	NULL	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
254	253	PAOLA	MARCELA	JARQUÍN	\N	\N	001-170987-1000C	\N	85514220	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
240	239	ARACELLYS	\N	RAMOS	\N	\N	NULL	\N	NULL	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
241	240	DAMIAN	\N	CASTILLO	\N	\N	NULL	\N	58612390	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
242	241	EMILYN	\N	GÓMEZ	\N	\N	NULL	\N	NULL	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
250	249	LISETH	\N	ARCIAS	\N	\N	001-261188-0031B	\N	NULL	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
251	250	LUBYANKA	\N	FIGUEROA	\N	\N	NULL	\N	78381648	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
255	254	RAMIRO	\N	LOAISIGA	\N	\N	NULL	\N	77782906	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
258	257	SHEYNON	\N	SALOMÓN	\N	\N	601-070703-1000J	\N	NULL	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
259	258	VALENTINA	\N	CARRIÓN	\N	\N	NULL	\N	78251311	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
260	260	VERONICA	\N	OBANDO	\N	\N	NULL	\N	76205349	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t
\.


--
-- TOC entry 2557 (class 0 OID 18781)
-- Dependencies: 201
-- Data for Name: tblcatdescuento; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tblcatdescuento (intidimpuesto, descripcion, numvalor, bolactivo)
VALUES(1, '10.00 %',0.10,'t'),
      (2, '5.00 %',	0.05,'t'),
	  (3, '0.00 %',	0.00,'t'),
	  (4, '15.00 %',0.15,'t'),
	  (5, '20.00 %',0.20,'t')
\.


--
-- TOC entry 2559 (class 0 OID 18789)
-- Dependencies: 203
-- Data for Name: tblcatexistencia; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatexistencia (intidserie, intidproducto, strnombreproducto, intexistencia, numcosto, total, datfechacreo, strusuariocreo, datfechamodifico, strusuariomodifico) FROM stdin;
48	48	MENSUALIDAD PROMOCIÓN MES	0	0.0	0.0	2021-05-12 19:37:38.147691	VBONILLA	\N	\N
2	2	SUSCRIPCION DIARIO	0	0	0	2021-04-26 18:54:08.771468	vilma_bonilla@yahoo.com	\N	\N
3	3	SEMANA	0	0	0	2021-05-03 20:20:55.104122	vilma_bonilla@yahoo.com	\N	\N
4	4	QUINCENA	0	0	0	2021-05-03 20:22:34.970685	vilma_bonilla@yahoo.com	\N	\N
5	5	MENSUALIDAD	0	0	0	2021-05-03 20:37:50.369528	vilma_bonilla@yahoo.com	\N	\N
13	13	AMINOS BEEF - DÓSIS 3 TABLETAS	131	6.83	894.73	2021-05-03 23:42:48.794109	vilma_bonilla@yahoo.com	\N	\N
14	14	AMINOS BEEF - TABLETA	394	2.28	898.32	2021-05-03 23:43:46.130021	vilma_bonilla@yahoo.com	\N	\N
18	18	D FRUTA SANDÍA 500ML	0	13.34	0.00	2021-05-08 16:52:02.234039	vilma_bonilla@yahoo.com	\N	\N
19	19	EAA/ BCAA - AMINO DRAGON PHARMA - DÓSIS TOMA	0	35	0	2021-05-08 16:54:17.621341	vilma_bonilla@yahoo.com	\N	\N
20	20	ELECTROLIT FRESA 650ML	2	86.40	172.80	2021-05-08 16:58:41.539299	vilma_bonilla@yahoo.com	\N	\N
21	21	ELECTROLIT NARANJA 650ML	2	86.40	172.80	2021-05-08 16:59:04.41935	vilma_bonilla@yahoo.com	\N	\N
22	22	ELECTROLIT UVA 650ML	2	86.40	172.80	2021-05-08 16:59:35.022685	vilma_bonilla@yahoo.com	\N	\N
23	23	GATORADE BERRY BLUE 600 ML	0	23.96	0.00	2021-05-08 17:06:59.658567	vilma_bonilla@yahoo.com	\N	\N
25	25	GATORADE LEMON LIME 600 ML	0	23.96	0.00	2021-05-08 17:28:28.424328	vilma_bonilla@yahoo.com	\N	\N
29	29	HYDROXYCUT MUSCLETECH - DÓSIS 2 CÁPSULAS	0	14.78	0.00	2021-05-10 22:05:08.028292	vilma_bonilla@yahoo.com	\N	\N
34	34	MONSTER AZUL 473ML	0	49	0	2021-05-10 22:19:53.237553	vilma_bonilla@yahoo.com	\N	\N
35	35	MONSTER MANGO 473ML	0	53	0	2021-05-10 22:20:30.196376	vilma_bonilla@yahoo.com	\N	\N
36	36	MONSTER VERDE 473ML	0	49	0	2021-05-10 22:21:05.725264	vilma_bonilla@yahoo.com	\N	\N
38	38	PRE - ENTRENO RC - DÓSIS TOMA	0	17.5	0.0	2021-05-10 22:27:09.838962	vilma_bonilla@yahoo.com	\N	\N
31	31	PALETAS	14	1.33	18.62	2021-05-10 22:07:08.60537	vilma_bonilla@yahoo.com	\N	\N
41	41	RAPTOR 600ML	1	22.5	22.5	2021-05-10 22:31:14.268624	vilma_bonilla@yahoo.com	\N	\N
39	39	PROTEÍNA MASS LIBRA	0	204.17	0.00	2021-05-10 22:29:10.163316	vilma_bonilla@yahoo.com	\N	\N
42	42	PROTEÍNA MASS FRASCO	0	1242.5	0.0	2021-05-10 22:33:59.050527	vilma_bonilla@yahoo.com	\N	\N
44	44	TESTOSTERONA MONSTER TEST - FRASCO	0	665	0	2021-05-10 22:38:17.341483	vilma_bonilla@yahoo.com	\N	\N
49	49	MENSUALIDAD PROMOCIÓN COLABORADOR	0	0.0	0.0	2021-05-12 19:38:31.825716	VBONILLA	\N	\N
26	26	GATORADE NARANJA 600 ML	1	23.96	23.96	2021-05-08 17:29:58.459077	vilma_bonilla@yahoo.com	\N	\N
16	16	AMP 365 AZUL 600ML	1	18	18	2021-05-03 23:45:48.200186	vilma_bonilla@yahoo.com	\N	\N
47	47	PRIX COLA 355ML	4	10	40	2021-05-10 23:29:24.19466	VBONILLA	\N	\N
28	28	HYDROXYCUT MUSCLETECH - CÁPSULA	147	7.39	1086.33	2021-05-08 17:33:02.554523	vilma_bonilla@yahoo.com	\N	\N
27	27	GATORADE UVA 600 ML	2	23.96	47.92	2021-05-08 17:30:20.542453	vilma_bonilla@yahoo.com	\N	\N
46	46	TROPICAL CERO FRUTA 500ML	12	21.15	253.80	2021-05-10 22:41:38.336231	vilma_bonilla@yahoo.com	\N	\N
43	43	TESTOSTERONA MONSTER TEST - DÓSIS 4 TABLETAS	12	22.17	266.04	2021-05-10 22:35:31.029411	vilma_bonilla@yahoo.com	\N	\N
45	45	TESTOSTERONA MONSTER TEST - TABLETA	38	5.54	210.52	2021-05-10 22:40:45.618878	vilma_bonilla@yahoo.com	\N	\N
37	37	PRE - ENTRENO APOCALYPSE - DÓSIS TOMA	36	24.50	882.00	2021-05-10 22:22:18.581124	vilma_bonilla@yahoo.com	\N	\N
12	12	AMINO 6000 DYMATIZE - TABLETA	432	2.10	907.20	2021-05-03 23:38:00.124877	vilma_bonilla@yahoo.com	\N	\N
30	30	BOMBONES	1	1.67	1.67	2021-05-10 22:06:18.00863	vilma_bonilla@yahoo.com	\N	\N
32	32	JET 600ML	25	21.72	543.00	2021-05-10 22:17:15.831497	vilma_bonilla@yahoo.com	\N	\N
40	40	RAPTOR 300ML	1	13.33	13.33	2021-05-10 22:30:07.508246	vilma_bonilla@yahoo.com	\N	\N
11	11	AMINO 6000 DYMATIZE - DÓSIS 3 TABLETAS	143	6.30	900.90	2021-05-03 23:36:40.631709	vilma_bonilla@yahoo.com	\N	\N
33	33	KERNS MANZANA 330ML	1	12.53	12.53	2021-05-10 22:19:02.086222	vilma_bonilla@yahoo.com	\N	\N
17	17	ANADROX MHP - TABLETA	183	7.03	1286.49	2021-05-03 23:47:29.697975	vilma_bonilla@yahoo.com	\N	\N
9	9	AMINO 2222 ON - DÓSIS 3 TABLETAS	9	9.19	82.71	2021-05-03 23:33:38.709624	vilma_bonilla@yahoo.com	\N	\N
6	6	AGUA FUENTE PURA 600 ML	53	13.33	706.49	2021-05-03 20:44:21.952761	vilma_bonilla@yahoo.com	\N	\N
7	7	AGUA FUENTE PURA 1000 ML	20	16.67	333.40	2021-05-03 20:46:27.916973	vilma_bonilla@yahoo.com	\N	\N
15	15	AMP 365 GRIS 600ML	10	18	180	2021-05-03 23:45:35.084858	vilma_bonilla@yahoo.com	\N	\N
50	50	GASEOSA PEPSI	10	10	100	2021-11-18 16:11:48.608305	jhonfc9011@hotmail.com	\N	\N
24	24	GATORADE FRUIT PUNCH 600 ML	10	23.96	239.60	2021-05-08 17:08:44.881052	vilma_bonilla@yahoo.com	\N	\N
8	8	AGUA FUENTE PURA 1500 ML	24	18.33	439.92	2021-05-03 21:49:13.310514	vilma_bonilla@yahoo.com	\N	\N
51	51	SEMANA PRUEBA	0	0.0	0.0	2021-11-19 19:40:46.495899	jhonfc9011@hotmail.com	\N	\N
52	52	RED BULL	9	20	180	2021-11-20 12:41:05.878039	jhonfc9011@hotmail.com	\N	\N
10	10	AMINO 2222 ON - TABLETA	43	3.06	131.58	2021-05-03 23:34:44.551572	vilma_bonilla@yahoo.com	\N	\N
53	53	ASISTIN	3	300	900	2022-03-26 15:12:39.078524	jhonfc9011@hotmail.com	\N	\N
\.


--
-- TOC entry 2561 (class 0 OID 18797)
-- Dependencies: 205
-- Data for Name: tblcatfacturadetalle; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatfacturadetalle (intidserie, intidfactura, intidproducto, numcantidad, strdescripcionproducto, numprecioventa, numsubttotal, numdescuento, numtotal, strusuariocreo, datfechacreo, datfechamodifico, strusuariomodifico, numimpuesto, numcosto) FROM stdin;
2	2	5	1	MENSUALIDAD-	500	500	0	500	VBONILLA	2021-05-10 15:35:06.094421	\N	\N	\N	0
3	3	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:36:49.641865	\N	\N	\N	0
4	4	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:37:54.986252	\N	\N	\N	0
5	5	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:39:56.650101	\N	\N	\N	0
6	6	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:40:29.482517	\N	\N	\N	0
7	7	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:41:08.362625	\N	\N	\N	0
8	8	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:42:06.25303	\N	\N	\N	0
9	9	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:43:51.275722	\N	\N	\N	0
10	10	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:45:52.428627	\N	\N	\N	0
11	11	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:46:16.938064	\N	\N	\N	0
12	12	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:48:39.695286	\N	\N	\N	0
13	13	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:49:03.95005	\N	\N	\N	0
14	14	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:49:30.378041	\N	\N	\N	0
15	15	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:49:50.122904	\N	\N	\N	0
16	16	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:50:16.873185	\N	\N	\N	0
17	17	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:50:36.36908	\N	\N	\N	0
18	18	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 15:53:14.156149	\N	\N	\N	0
19	19	7	2	AGUA FUENTE PURA 1000 ML-1000 ML	20	40	0	40	VBONILLA	2021-05-10 15:54:33.066071	\N	\N	\N	16.67
20	19	8	2	AGUA FUENTE PURA 1500 ML-1500 ML	25	50	0	50	VBONILLA	2021-05-10 15:54:56.62481	\N	\N	\N	19.17
21	19	6	1	AGUA FUENTE PURA 600 ML-600 ML	16	16	0	16	VBONILLA	2021-05-10 15:55:14.034577	\N	\N	\N	13.33
22	19	30	4	BOMBONES-UNIDAD	4	16	0	16	VBONILLA	2021-05-10 15:55:53.453126	\N	\N	\N	1.67
23	19	32	1	JET 600ML-600 ML	26	26	0	26	VBONILLA	2021-05-10 15:56:05.135678	\N	\N	\N	21.72
24	19	31	2	PALETAS-UNIDAD	4	8	0	8	VBONILLA	2021-05-10 15:56:16.912583	\N	\N	\N	1.33
25	19	40	2	RAPTOR 300ML-300 ML	19	38	0	38	VBONILLA	2021-05-10 15:56:27.530612	\N	\N	\N	13.33
26	20	4	1	QUINCENA-	300	300	0	300	VBONILLA	2021-05-10 16:00:50.800123	\N	\N	\N	0
27	21	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 16:13:18.030503	\N	\N	\N	0
28	22	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 16:13:47.02235	\N	\N	\N	0
29	23	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 16:14:24.457362	\N	\N	\N	0
30	24	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 16:18:56.682133	\N	\N	\N	0
31	25	26	1	GATORADE NARANJA 600 ML-600 ML	30	30	0	30	VBONILLA	2021-05-10 16:22:34.669278	\N	\N	\N	23.96
32	25	28	1	HYDROXYCUT MUSCLETECH - CÁPSULA-CÁPSULA	20	20	0	20	VBONILLA	2021-05-10 16:22:39.178778	\N	\N	\N	7.39
33	25	15	1	AMP 365 GRIS 600ML-600 ML	26	26	0	26	VBONILLA	2021-05-10 16:22:55.724526	\N	\N	\N	18
34	26	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-10 16:25:47.276956	\N	\N	\N	0
38	30	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-11 15:35:34.53795	\N	\N	\N	0
39	31	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-11 15:36:18.158569	\N	\N	\N	0
40	32	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-11 15:37:06.670508	\N	\N	\N	0
41	33	7	1	AGUA FUENTE PURA 1000 ML-1000 ML	20	20	0	20	VBONILLA	2021-05-11 15:37:47.885039	\N	\N	\N	16.67
42	33	26	1	GATORADE NARANJA 600 ML-600 ML	30	30	0	30	VBONILLA	2021-05-11 15:38:10.091693	\N	\N	\N	23.96
43	33	24	1	GATORADE FRUIT PUNCH 600 ML-600 ML	30	30	0	30	VBONILLA	2021-05-11 15:38:20.714039	\N	\N	\N	23.96
44	33	9	1	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	20	0	20	VBONILLA	2021-05-11 15:38:34.569399	\N	\N	\N	9.19
45	34	9	1	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	20	0	20	VBONILLA	2021-05-11 15:44:42.760852	\N	\N	\N	9.19
46	34	27	1	GATORADE UVA 600 ML-600 ML	30	30	0	30	VBONILLA	2021-05-11 15:44:53.610951	\N	\N	\N	23.96
47	35	17	1	ANADROX MHP - TABLETA-TABLETA	20	20	0	20	VBONILLA	2021-05-11 16:05:09.903419	\N	\N	\N	7.03
48	35	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-11 16:05:14.349154	\N	\N	\N	0
49	35	31	1	PALETAS-UNIDAD	4	4	0	4	VBONILLA	2021-05-11 16:05:19.370613	\N	\N	\N	1.33
50	36	28	1	HYDROXYCUT MUSCLETECH - CÁPSULA-CÁPSULA	20	20	0	20	VBONILLA	2021-05-11 16:27:49.131819	\N	\N	\N	7.39
51	36	33	1	KERNS MANZANA 330ML-330ML	15	15	0	15	VBONILLA	2021-05-11 16:27:58.541388	\N	\N	\N	12.53
52	37	2	1	DIARIO-	30	30	0	30	VBONILLA	2021-05-11 16:28:49.193929	\N	\N	\N	0
53	38	31	2	PALETAS-UNIDAD	4	8	0	8	RPRAVIA	2021-05-11 16:46:34.826251	\N	\N	\N	1.33
54	39	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-11 17:29:41.449822	\N	\N	\N	0
55	40	2	2	DIARIO-	30	60	0	60	RPRAVIA	2021-05-11 17:32:08.396686	\N	\N	\N	0
56	41	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-11 17:33:27.408621	\N	\N	\N	0
57	42	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-11 18:03:17.128083	\N	\N	\N	0
58	43	47	1	PRIX COLA 355ML-355 ML	12	12	0	12	RPRAVIA	2021-05-11 18:06:11.883902	\N	\N	\N	10
59	44	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-11 18:08:50.346235	\N	\N	\N	0
60	45	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 19:01:02.473317	\N	\N	\N	0
61	46	7	1	AGUA FUENTE PURA 1000 ML-1000 ML	20	20	0	20	RPRAVIA	2021-05-12 19:24:35.564817	\N	\N	\N	16.67
62	47	30	1	BOMBONES-UNIDAD	4	4	0	4	RPRAVIA	2021-05-12 19:35:08.044667	\N	\N	\N	1.67
63	48	33	1	KERNS MANZANA 330ML-330ML	15	15	0	15	RPRAVIA	2021-05-12 19:36:33.640503	\N	\N	\N	12.53
64	49	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 19:37:48.264601	\N	\N	\N	0
65	50	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 19:38:33.864707	\N	\N	\N	0
66	51	48	1	MENSUALIDAD PROMOCIÓN MES-	450	450	0	450	RPRAVIA	2021-05-12 19:40:02.928519	\N	\N	\N	0.0
67	52	48	1	MENSUALIDAD PROMOCIÓN MES-	450	450	0	450	RPRAVIA	2021-05-12 19:43:49.771411	\N	\N	\N	0.0
68	53	48	1	MENSUALIDAD PROMOCIÓN MES-	450	450	0	450	RPRAVIA	2021-05-12 19:44:44.681687	\N	\N	\N	0.0
69	54	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 19:49:11.02042	\N	\N	\N	0
70	55	9	1	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	20	0	20	RPRAVIA	2021-05-12 19:50:05.001496	\N	\N	\N	9.19
71	56	24	1	GATORADE FRUIT PUNCH 600 ML-600 ML	30	30	0	30	RPRAVIA	2021-05-12 19:51:20.232497	\N	\N	\N	23.96
72	57	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 19:54:42.123219	\N	\N	\N	0
73	58	31	1	PALETAS-UNIDAD	4	4	0	4	RPRAVIA	2021-05-12 19:55:45.772901	\N	\N	\N	1.33
74	59	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 19:56:41.896322	\N	\N	\N	0
75	60	33	1	KERNS MANZANA 330ML-330ML	15	15	0	15	RPRAVIA	2021-05-12 19:57:19.628553	\N	\N	\N	12.53
76	61	17	1	ANADROX MHP - TABLETA-TABLETA	20	20	0	20	RPRAVIA	2021-05-12 19:59:10.088511	\N	\N	\N	7.03
77	62	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 20:02:34.729534	\N	\N	\N	0
78	62	31	1	PALETAS-UNIDAD	4	4	0	4	RPRAVIA	2021-05-12 20:02:45.613786	\N	\N	\N	1.33
79	63	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 20:04:58.954082	\N	\N	\N	0
80	64	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 20:07:02.603834	\N	\N	\N	0
81	64	30	1	BOMBONES-UNIDAD	4	4	0	4	RPRAVIA	2021-05-12 20:07:23.314695	\N	\N	\N	1.67
82	65	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 20:09:04.521303	\N	\N	\N	0
83	66	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 20:14:22.892433	\N	\N	\N	0
84	67	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 20:15:11.916196	\N	\N	\N	0
85	68	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 20:16:22.320409	\N	\N	\N	0
86	69	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-12 20:17:03.947896	\N	\N	\N	0
87	69	41	1	RAPTOR 600ML-600 ML	29	29	0	29	RPRAVIA	2021-05-12 20:17:46.857054	\N	\N	\N	22.5
88	70	37	1	PRE - ENTRENO APOCALYPSE - DÓSIS TOMA-TOMA	40	40	0	40	RPRAVIA	2021-05-12 20:20:50.30963	\N	\N	\N	24.50
89	71	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-13 14:27:51.27286	\N	\N	\N	0
90	72	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-13 14:31:47.592669	\N	\N	\N	0
91	73	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-13 14:32:36.299413	\N	\N	\N	0
92	73	9	1	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	20	0	20	RPRAVIA	2021-05-13 14:33:29.389462	\N	\N	\N	9.19
93	74	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-13 14:35:44.201627	\N	\N	\N	0
94	74	7	1	AGUA FUENTE PURA 1000 ML-1000 ML	20	20	0	20	RPRAVIA	2021-05-13 14:36:27.597374	\N	\N	\N	16.67
95	74	27	1	GATORADE UVA 600 ML-600 ML	30	30	0	30	RPRAVIA	2021-05-13 14:36:57.000526	\N	\N	\N	23.96
96	74	33	1	KERNS MANZANA 330ML-330ML	15	15	0	15	RPRAVIA	2021-05-13 14:37:23.113088	\N	\N	\N	12.53
97	75	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-13 14:39:17.035966	\N	\N	\N	0
98	76	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-13 15:52:21.32327	\N	\N	\N	0
99	76	9	1	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	20	0	20	RPRAVIA	2021-05-13 15:52:36.397164	\N	\N	\N	9.19
100	76	17	1	ANADROX MHP - TABLETA-TABLETA	20	20	0	20	RPRAVIA	2021-05-13 15:52:52.266756	\N	\N	\N	7.03
101	77	30	2	BOMBONES-UNIDAD	4	8	0	8	RPRAVIA	2021-05-13 15:56:22.250733	\N	\N	\N	1.67
102	78	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-13 16:55:36.552889	\N	\N	\N	0
103	79	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-13 18:01:13.096346	\N	\N	\N	0
104	80	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-13 18:30:33.836708	\N	\N	\N	0
105	80	37	1	PRE - ENTRENO APOCALYPSE - DÓSIS TOMA-TOMA	40	40	0	40	RPRAVIA	2021-05-13 18:30:49.614103	\N	\N	\N	24.50
106	81	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-13 18:49:06.248277	\N	\N	\N	0
107	82	40	1	RAPTOR 300ML-300 ML	19	19	0	19	RPRAVIA	2021-05-13 19:08:05.736439	\N	\N	\N	13.33
108	83	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-14 13:51:10.184144	\N	\N	\N	0
109	84	11	1	AMINO 6000 DYMATIZE - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	20	0	20	RPRAVIA	2021-05-14 13:53:35.854772	\N	\N	\N	6.30
110	84	45	1	TESTOSTERONA MONSTER TEST - TABLETA-TABLETA	10	10	0	10	RPRAVIA	2021-05-14 13:54:35.466355	\N	\N	\N	5.54
111	84	37	1	PRE - ENTRENO APOCALYPSE - DÓSIS TOMA-TOMA	40	40	0	40	RPRAVIA	2021-05-14 13:54:51.242483	\N	\N	\N	24.50
112	85	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-14 13:56:13.038707	\N	\N	\N	0
113	86	9	1	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	20	0	20	RPRAVIA	2021-05-14 13:57:28.016067	\N	\N	\N	9.19
114	86	41	1	RAPTOR 600ML-600 ML	29	29	0	29	RPRAVIA	2021-05-14 13:57:53.069174	\N	\N	\N	22.5
115	87	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-14 14:01:44.521078	\N	\N	\N	0
116	87	24	1	GATORADE FRUIT PUNCH 600 ML-600 ML	30	30	0	30	RPRAVIA	2021-05-14 14:03:02.216017	\N	\N	\N	23.96
117	88	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-14 14:05:39.561025	\N	\N	\N	0
118	89	40	1	RAPTOR 300ML-300 ML	19	19	0	19	RPRAVIA	2021-05-14 14:06:35.178283	\N	\N	\N	13.33
119	89	27	2	GATORADE UVA 600 ML-600 ML	30	60	0	60	RPRAVIA	2021-05-14 14:06:58.601077	\N	\N	\N	23.96
120	89	7	1	AGUA FUENTE PURA 1000 ML-1000 ML	20	20	0	20	RPRAVIA	2021-05-14 14:07:15.272676	\N	\N	\N	16.67
121	90	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-14 15:49:48.52637	\N	\N	\N	0
122	90	47	1	PRIX COLA 355ML-355 ML	12	12	0	12	RPRAVIA	2021-05-14 15:49:59.816963	\N	\N	\N	10
123	91	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-14 16:34:50.668738	\N	\N	\N	0
124	91	30	1	BOMBONES-UNIDAD	4	4	0	4	RPRAVIA	2021-05-14 16:35:04.393312	\N	\N	\N	1.67
125	92	33	1	KERNS MANZANA 330ML-330ML	15	15	0	15	RPRAVIA	2021-05-14 16:35:52.843677	\N	\N	\N	12.53
126	93	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-14 17:00:30.185831	\N	\N	\N	0
127	94	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-14 17:53:43.047961	\N	\N	\N	0
128	95	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-14 18:04:06.279339	\N	\N	\N	0
129	96	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-14 18:38:38.32213	\N	\N	\N	0
130	96	40	1	RAPTOR 300ML-300 ML	19	19	0	19	RPRAVIA	2021-05-14 18:38:57.808716	\N	\N	\N	13.33
131	97	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-15 08:11:08.745887	\N	\N	\N	0
132	97	9	1	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	20	0	20	RPRAVIA	2021-05-15 08:11:23.050217	\N	\N	\N	9.19
133	97	24	1	GATORADE FRUIT PUNCH 600 ML-600 ML	30	30	0	30	RPRAVIA	2021-05-15 08:11:36.632698	\N	\N	\N	23.96
134	98	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-15 09:10:12.909484	\N	\N	\N	0
135	98	7	1	AGUA FUENTE PURA 1000 ML-1000 ML	20	20	0	20	RPRAVIA	2021-05-15 09:10:21.289899	\N	\N	\N	16.67
136	99	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-15 11:37:00.393985	\N	\N	\N	0
137	99	24	1	GATORADE FRUIT PUNCH 600 ML-600 ML	30	30	0	30	RPRAVIA	2021-05-15 11:38:23.469941	\N	\N	\N	23.96
138	100	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 14:29:52.653588	\N	\N	\N	0
139	101	4	1	QUINCENA-	300	300	0	300	RPRAVIA	2021-05-17 14:49:57.866811	\N	\N	\N	0
140	102	4	1	QUINCENA-	300	300	0	300	RPRAVIA	2021-05-17 14:57:40.295492	\N	\N	\N	0
141	103	5	1	MENSUALIDAD-	500	500	0	500	RPRAVIA	2021-05-17 14:59:07.979228	\N	\N	\N	0
142	104	31	2	PALETAS-UNIDAD	4	8	0	8	RPRAVIA	2021-05-17 15:00:50.508282	\N	\N	\N	1.33
143	105	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 15:01:42.504682	\N	\N	\N	0
144	106	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 15:02:28.107247	\N	\N	\N	0
145	106	26	1	GATORADE NARANJA 600 ML-600 ML	30	30	0	30	RPRAVIA	2021-05-17 15:02:44.908382	\N	\N	\N	23.96
146	107	41	1	RAPTOR 600ML-600 ML	29	29	0	29	RPRAVIA	2021-05-17 15:03:35.273254	\N	\N	\N	22.5
147	107	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 15:03:49.864823	\N	\N	\N	0
148	108	9	1	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	20	0	20	RPRAVIA	2021-05-17 15:07:49.544202	\N	\N	\N	9.19
149	108	37	1	PRE - ENTRENO APOCALYPSE - DÓSIS TOMA-TOMA	40	40	0	40	RPRAVIA	2021-05-17 15:08:02.634247	\N	\N	\N	24.50
150	108	45	1	TESTOSTERONA MONSTER TEST - TABLETA-TABLETA	10	10	0	10	RPRAVIA	2021-05-17 15:09:17.135536	\N	\N	\N	5.54
151	109	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 16:41:03.433407	\N	\N	\N	0
152	109	27	1	GATORADE UVA 600 ML-600 ML	30	30	0	30	RPRAVIA	2021-05-17 16:41:40.39288	\N	\N	\N	23.96
153	110	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 16:42:49.42181	\N	\N	\N	0
154	110	31	1	PALETAS-UNIDAD	4	4	0	4	RPRAVIA	2021-05-17 16:43:04.394254	\N	\N	\N	1.33
155	110	17	1	ANADROX MHP - TABLETA-TABLETA	20	20	0	20	RPRAVIA	2021-05-17 16:43:17.324705	\N	\N	\N	7.03
156	110	9	1	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	20	0	20	RPRAVIA	2021-05-17 16:43:30.476206	\N	\N	\N	9.19
157	111	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 16:50:34.220289	\N	\N	\N	0
158	112	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 19:18:42.540836	\N	\N	\N	0
159	113	40	1	RAPTOR 300ML-300 ML	19	19	0	19	RPRAVIA	2021-05-17 19:20:13.358949	\N	\N	\N	13.33
160	113	31	1	PALETAS-UNIDAD	4	4	0	4	RPRAVIA	2021-05-17 19:20:43.147799	\N	\N	\N	1.33
161	113	30	2	BOMBONES-UNIDAD	4	8	0	8	RPRAVIA	2021-05-17 19:21:29.095435	\N	\N	\N	1.67
162	114	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 19:23:28.844785	\N	\N	\N	0
163	115	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 19:25:03.209159	\N	\N	\N	0
164	116	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 19:28:14.444141	\N	\N	\N	0
165	117	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 19:29:01.550915	\N	\N	\N	0
166	118	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 19:30:06.955891	\N	\N	\N	0
167	119	8	1	AGUA FUENTE PURA 1500 ML-1500 ML	25	25	0	25	RPRAVIA	2021-05-17 19:31:07.593186	\N	\N	\N	19.17
168	119	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-17 19:31:50.600921	\N	\N	\N	0
169	121	45	2	TESTOSTERONA MONSTER TEST - TABLETA-TABLETA	10	20	0	20	RPRAVIA	2021-05-18 15:22:08.330028	\N	\N	\N	5.54
170	121	37	1	PRE - ENTRENO APOCALYPSE - DÓSIS TOMA-TOMA	40	40	0	40	RPRAVIA	2021-05-18 15:22:32.232254	\N	\N	\N	24.50
171	121	12	1	AMINO 6000 DYMATIZE - TABLETA-TABLETA	10	10	0	10	RPRAVIA	2021-05-18 15:23:48.267887	\N	\N	\N	2.10
172	122	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-18 15:25:37.452358	\N	\N	\N	0
173	122	7	1	AGUA FUENTE PURA 1000 ML-1000 ML	20	20	0	20	RPRAVIA	2021-05-18 15:25:52.172629	\N	\N	\N	16.67
174	123	5	1	MENSUALIDAD-	500	500	0	500	RPRAVIA	2021-05-18 15:27:25.897445	\N	\N	\N	0
175	124	30	2	BOMBONES-UNIDAD	4	8	0	8	RPRAVIA	2021-05-18 17:02:38.151645	\N	\N	\N	1.67
176	125	30	2	BOMBONES-UNIDAD	4	8	0	8	RPRAVIA	2021-05-18 17:04:25.003755	\N	\N	\N	1.67
177	126	30	1	BOMBONES-UNIDAD	4	4	0	4	RPRAVIA	2021-05-18 17:04:52.876019	\N	\N	\N	1.67
178	127	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-18 17:05:38.988684	\N	\N	\N	0
179	127	9	1	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	20	0	20	RPRAVIA	2021-05-18 17:07:21.801519	\N	\N	\N	9.19
180	127	33	1	KERNS MANZANA 330ML-330ML	15	15	0	15	RPRAVIA	2021-05-18 17:07:35.882892	\N	\N	\N	12.53
181	128	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-18 17:08:52.553135	\N	\N	\N	0
182	129	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-18 17:10:33.128326	\N	\N	\N	0
183	130	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-18 17:11:20.431167	\N	\N	\N	0
184	131	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-18 17:12:00.263558	\N	\N	\N	0
185	132	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-18 17:12:46.093526	\N	\N	\N	0
186	133	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-18 17:13:27.497109	\N	\N	\N	0
187	134	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-18 17:14:11.687712	\N	\N	\N	0
188	135	40	1	RAPTOR 300ML-300 ML	19	19	0	19	RPRAVIA	2021-05-18 17:14:51.721644	\N	\N	\N	13.33
189	136	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-18 17:16:04.072216	\N	\N	\N	0
190	137	5	1	MENSUALIDAD-	500	500	0	500	RPRAVIA	2021-05-18 17:21:55.752708	\N	\N	\N	0
191	138	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-18 18:11:20.776059	\N	\N	\N	0
192	138	8	1	AGUA FUENTE PURA 1500 ML-1500 ML	25	25	0	25	RPRAVIA	2021-05-18 18:11:30.309612	\N	\N	\N	19.17
193	139	24	2	GATORADE FRUIT PUNCH 600 ML-600 ML	30	60	0	60	RPRAVIA	2021-05-18 18:45:48.237606	\N	\N	\N	23.96
194	140	48	1	MENSUALIDAD PROMOCIÓN MES-	450	450	0	450	RPRAVIA	2021-05-18 19:53:58.413975	\N	\N	\N	0.0
195	141	48	1	MENSUALIDAD PROMOCIÓN MES-	450	450	0	450	RPRAVIA	2021-05-18 19:54:43.560455	\N	\N	\N	0.0
196	142	41	1	RAPTOR 600ML-600 ML	29	29	0	29	VBONILLA	2021-05-18 21:01:02.827196	\N	\N	\N	22.5
197	143	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-19 14:21:11.753899	\N	\N	\N	0
198	144	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-19 14:22:28.046	\N	\N	\N	0
199	144	9	1	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	20	0	20	RPRAVIA	2021-05-19 14:23:10.473406	\N	\N	\N	9.19
200	145	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-19 14:24:01.9936	\N	\N	\N	0
201	145	33	2	KERNS MANZANA 330ML-330ML	15	30	0	30	RPRAVIA	2021-05-19 14:24:40.587996	\N	\N	\N	12.53
202	145	24	1	GATORADE FRUIT PUNCH 600 ML-600 ML	30	30	0	30	RPRAVIA	2021-05-19 14:25:54.632738	\N	\N	\N	23.96
203	145	47	1	PRIX COLA 355ML-355 ML	12	12	0	12	RPRAVIA	2021-05-19 14:26:26.828905	\N	\N	\N	10
204	145	8	1	AGUA FUENTE PURA 1500 ML-1500 ML	25	25	0	25	RPRAVIA	2021-05-19 14:26:33.322381	\N	\N	\N	19.17
205	146	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-19 16:56:11.372828	\N	\N	\N	0
206	147	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-19 16:56:43.304756	\N	\N	\N	0
207	147	17	1	ANADROX MHP - TABLETA-TABLETA	20	20	0	20	RPRAVIA	2021-05-19 16:56:51.977743	\N	\N	\N	7.03
208	148	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-19 18:19:04.778997	\N	\N	\N	0
209	149	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-19 18:19:43.697679	\N	\N	\N	0
210	150	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-19 18:20:32.23611	\N	\N	\N	0
211	151	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-19 18:55:26.952592	\N	\N	\N	0
212	152	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-19 19:42:51.560007	\N	\N	\N	0
213	152	31	1	PALETAS-UNIDAD	4	4	0	4	RPRAVIA	2021-05-19 19:43:01.894153	\N	\N	\N	1.33
214	153	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-20 16:15:43.244783	\N	\N	\N	0
215	153	9	1	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	20	0	20	RPRAVIA	2021-05-20 16:16:57.675808	\N	\N	\N	9.19
216	154	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-20 16:18:10.987584	\N	\N	\N	0
217	155	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-20 16:18:45.193327	\N	\N	\N	0
218	156	33	1	KERNS MANZANA 330ML-330ML	15	15	0	15	RPRAVIA	2021-05-20 16:21:34.735667	\N	\N	\N	12.53
219	157	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-21 18:05:27.150974	\N	\N	\N	0
220	157	30	1	BOMBONES-UNIDAD	4	4	0	4	RPRAVIA	2021-05-21 18:05:35.218095	\N	\N	\N	1.67
221	158	30	1	BOMBONES-UNIDAD	4	4	0	4	RPRAVIA	2021-05-21 18:09:55.534743	\N	\N	\N	1.67
222	159	30	1	BOMBONES-UNIDAD	4	4	0	4	RPRAVIA	2021-05-21 18:10:48.779838	\N	\N	\N	1.67
223	160	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-21 18:12:25.492035	\N	\N	\N	0
224	161	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-21 18:13:10.323128	\N	\N	\N	0
225	162	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-21 18:14:02.515133	\N	\N	\N	0
226	163	2	2	DIARIO-	30	60	0	60	RPRAVIA	2021-05-21 18:15:07.564536	\N	\N	\N	0
227	164	41	1	RAPTOR 600ML-600 ML	29	29	0	29	RPRAVIA	2021-05-21 18:16:04.362326	\N	\N	\N	22.5
228	166	24	1	GATORADE FRUIT PUNCH 600 ML-600 ML	30	30	0	30	RPRAVIA	2021-05-21 18:17:07.950487	\N	\N	\N	23.96
229	166	24	1	GATORADE FRUIT PUNCH 600 ML-600 ML	30	30	0	30	RPRAVIA	2021-05-21 18:17:44.457628	\N	\N	\N	23.96
230	167	33	1	KERNS MANZANA 330ML-330ML	15	15	0	15	RPRAVIA	2021-05-21 18:19:31.307166	\N	\N	\N	12.53
231	168	33	1	KERNS MANZANA 330ML-330ML	15	15	0	15	RPRAVIA	2021-05-21 18:20:46.447306	\N	\N	\N	12.53
232	169	33	1	KERNS MANZANA 330ML-330ML	15	15	0	15	RPRAVIA	2021-05-21 18:21:32.91013	\N	\N	\N	12.53
233	170	47	1	PRIX COLA 355ML-355 ML	12	12	0	12	RPRAVIA	2021-05-21 18:22:06.346448	\N	\N	\N	10
234	171	28	1	HYDROXYCUT MUSCLETECH - CÁPSULA-CÁPSULA	20	20	0	20	RPRAVIA	2021-05-21 18:23:07.151751	\N	\N	\N	7.39
235	171	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-21 18:23:35.049569	\N	\N	\N	0
236	172	4	1	QUINCENA-	300	300	0	300	RPRAVIA	2021-05-21 18:25:16.846538	\N	\N	\N	0
237	173	2	1	DIARIO-	30	30	0	30	RPRAVIA	2021-05-21 18:26:50.543186	\N	\N	\N	0
238	173	30	1	BOMBONES-UNIDAD	4	4	0	4	RPRAVIA	2021-05-21 18:26:56.400569	\N	\N	\N	1.67
239	174	30	1	BOMBONES-UNIDAD	4	4	0	4	RPRAVIA	2021-05-21 18:28:07.534672	\N	\N	\N	1.67
240	175	30	1	BOMBONES-UNIDAD	4	4	0	4	RPRAVIA	2021-05-21 18:28:45.866199	\N	\N	\N	1.67
241	176	41	1	RAPTOR 600ML-600 ML	29	29	0	29	RPRAVIA	2021-05-25 17:50:12.489335	\N	\N	\N	22.5
242	177	5	1	MENSUALIDAD-	500	500	0	500	jhonfc9011@hotmail.com	2021-06-14 16:05:47.17156	\N	\N	\N	0
243	178	5	1	MENSUALIDAD-	500	500	0	500	jhonfc9011@hotmail.com	2021-06-20 17:27:57.12688	\N	\N	\N	0
244	179	7	1	AGUA FUENTE PURA 1000 ML-1000 ML	20	20	0	20	jhonfc9011@hotmail.com	2021-09-04 12:27:41.971709	\N	\N	\N	16.67
245	180	7	1	AGUA FUENTE PURA 1000 ML-1000 ML	20	20	0	20	jhonfc9011@hotmail.com	2021-09-04 12:30:37.279698	\N	\N	\N	16.67
246	181	7	1	AGUA FUENTE PURA 1000 ML-1000 ML	20	20	0	20	jhonfc9011@hotmail.com	2021-09-04 16:28:51.63969	\N	\N	\N	16.67
247	182	8	1	AGUA FUENTE PURA 1500 ML-1500 ML	25	25	0	25	jhonfc9011@hotmail.com	2021-09-04 16:35:12.214205	\N	\N	\N	19.17
248	183	7	1	AGUA FUENTE PURA 1000 ML-1000 ML	20	20	0	20	jhonfc9011@hotmail.com	2021-09-11 21:30:58.880817	\N	\N	\N	16.67
249	184	5	1	MENSUALIDAD-	500	500	0	500	jhonfc9011@hotmail.com	2021-09-22 19:32:11.986269	\N	\N	\N	0
250	185	5	1	MENSUALIDAD-	500	500	0	500	jhonfc9011@hotmail.com	2021-11-14 11:31:02.191261	\N	\N	\N	0
251	186	5	1	MENSUALIDAD-	500	500	0	500	jhonfc9011@hotmail.com	2021-11-14 11:41:06.12382	\N	\N	\N	0
252	187	5	1	MENSUALIDAD-	500	500	0	500	jhonfc9011@hotmail.com	2021-11-14 18:36:22.365528	\N	\N	\N	0
253	188	52	1	RED BULL	40	40	0	40	jhonfc9011@hotmail.com	2021-11-20 12:45:35.990068	\N	\N	\N	\N
254	188	5	1	MENSUALIDAD-	500	500	0	500	jhonfc9011@hotmail.com	2021-11-20 12:46:02.971867	\N	\N	\N	0
255	189	10	10	AMINO 2222 ON - TABLETA-TABLETA	10	100	0	100	jhonfc9011@hotmail.com	2021-11-20 12:50:32.081005	\N	\N	\N	3.06
256	190	7	1	AGUA FUENTE PURA 1000 ML-1000 ML	20	20	0	20	jhonfc9011@hotmail.com	2022-02-21 10:30:22.428596	\N	\N	\N	16.67
257	191	7	2	AGUA FUENTE PURA 1000 ML-1000 ML	20	40	0	40	jhonfc9011@hotmail.com	2022-02-21 14:27:01.19072	\N	\N	\N	16.67
258	192	7	2	AGUA FUENTE PURA 1000 ML-1000 ML	20	40	0	40	jhonfc9011@hotmail.com	2022-02-27 20:01:07.043729	\N	\N	\N	16.67
259	193	3	1	SEMANA	170	170	0	170	jhonfc9011@hotmail.com	2022-03-18 23:08:46.268587	\N	\N	\N	\N
260	194	5	1	MENSUALIDAD-	500	500	0.05	475	jhonfc9011@hotmail.com	2022-03-26 21:15:07.475361	\N	\N	\N	0
261	194	7	1	AGUA FUENTE PURA 1000 ML-1000 ML	20	20	0	20	jhonfc9011@hotmail.com	2022-03-26 21:15:16.418545	\N	\N	\N	16.67
262	196	9	2	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	20	40	0	40	jhonfc9011@hotmail.com	2022-03-26 21:43:39.488194	\N	\N	\N	9.19
263	197	7	1	AGUA FUENTE PURA 1000 ML-1000 ML	20	20	0	20	jhonfc9011@hotmail.com	2022-03-26 21:50:11.227965	\N	\N	\N	16.67
264	198	24	2	GATORADE FRUIT PUNCH 600 ML-600 ML	30	60	0	60	jhonfc9011@hotmail.com	2022-03-27 10:38:56.50609	\N	\N	\N	23.96
\.


--
-- TOC entry 2562 (class 0 OID 18803)
-- Dependencies: 206
-- Data for Name: tblcatfacturadetalle_compra; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatfacturadetalle_compra (intidserie, intidfactura, intidproducto, numcantidad, strdescripcionproducto, numprecioventa, numsubttotal, numdescuento, numtotal, strusuariocreo, datfechacreo, datfechamodifico, strusuariomodifico, numimpuesto, numcantbonificado) FROM stdin;
2	3	6	10	AGUA FUENTE PURA 600 ML-600 ML	13.33	133.3	0	133.3	jhonfc9011@hotmail.com	2021-09-10 11:15:30.877303	\N	\N	\N	0
3	4	6	10	AGUA FUENTE PURA 600 ML-600 ML	13.33	133.3	0	133.3	jhonfc9011@hotmail.com	2021-09-11 11:44:09.421957	\N	\N	\N	0
4	5	7	10	AGUA FUENTE PURA 1000 ML-1000 ML	16.67	166.7	0	166.7	jhonfc9011@hotmail.com	2021-09-11 22:18:36.200914	\N	\N	\N	0
5	6	8	10	AGUA FUENTE PURA 1500 ML-1500 ML	19.17	191.7	0	191.7	jhonfc9011@hotmail.com	2021-09-11 22:26:00.065244	\N	\N	\N	0
6	7	6	10	AGUA FUENTE PURA 600 ML-600 ML	13.33	133.3	0	133.3	jhonfc9011@hotmail.com	2021-09-11 22:32:15.046589	\N	\N	\N	0
7	8	6	10	AGUA FUENTE PURA 600 ML-600 ML	13.33	133.3	0	133.3	jhonfc9011@hotmail.com	2021-11-13 23:07:09.432969	\N	\N	\N	2
8	9	6	10	AGUA FUENTE PURA 600 ML-600 ML	13.33	133.3	0	133.3	jhonfc9011@hotmail.com	2021-11-13 23:07:09.432969	\N	\N	\N	2
9	10	6	10	AGUA FUENTE PURA 600 ML-600 ML	13.33	133.3	0	133.3	jhonfc9011@hotmail.com	2021-11-13 23:07:09.432969	\N	\N	\N	2
10	11	6	1	AGUA FUENTE PURA 600 ML-600 ML	13.33	13.33	0	13.33	jhonfc9011@hotmail.com	2021-11-14 10:45:25.111324	\N	\N	\N	0
11	12	24	10	GATORADE FRUIT PUNCH 600 ML-600 ML	23.96	239.6	0	239.6	jhonfc9011@hotmail.com	2022-02-27 11:09:02.194356	\N	\N	\N	2
12	13	6	10	AGUA FUENTE PURA 600 ML-600 ML	13.33	133.3	0	133.3	jhonfc9011@hotmail.com	2022-02-27 19:43:10.132726	\N	\N	\N	0
13	14	15	10	AMP 365 GRIS 600ML-600 ML	18	180	0	180	jhonfc9011@hotmail.com	2022-03-05 13:09:31.505258	\N	\N	\N	0
14	15	9	1	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	9.19	9.19	0	9.19	jhonfc9011@hotmail.com	2022-03-13 16:00:27.776533	\N	\N	\N	10
15	16	9	10	AMINO 2222 ON - DÓSIS 3 TABLETAS-DÓSIS 3 TABLETAS	9.19	91.9	0	91.9	jhonfc9011@hotmail.com	2022-03-13 16:50:24.467111	\N	\N	\N	0
\.


--
-- TOC entry 2565 (class 0 OID 18813)
-- Dependencies: 209
-- Data for Name: tblcatfacturaencabezado; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatfacturaencabezado (intidserie, intidcliente, datfechafactura, numtasacambio, numsubtotal, numdescuento, numiva, numtotal, bolanulado, boldevolucion, strusuariocreo, datfechacreo, datfechamodifico, strusuariomodifico, strestado, strtipo, numerofactura, numdescuentovalor, numimpuestovalor) FROM stdin;
2	261	2021-05-10 15:35:14.70449	34.50	500.00	0.00	0.00	500.00	f	f	VBONILLA	2021-05-10 15:35:14.70449	\N	\N	CERRADO	CONTADO	1	0.00	0.00
3	40	2021-05-10 15:36:55.728098	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:36:55.728098	\N	\N	CERRADO	CONTADO	2	0.00	0.00
4	148	2021-05-10 15:38:05.294437	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:38:05.294437	\N	\N	CERRADO	CONTADO	3	0.00	0.00
5	133	2021-05-10 15:40:03.854707	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:40:03.854707	\N	\N	CERRADO	CONTADO	4	0.00	0.00
6	138	2021-05-10 15:40:35.220015	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:40:35.220015	\N	\N	CERRADO	CONTADO	5	0.00	0.00
7	108	2021-05-10 15:41:13.553198	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:41:13.553198	\N	\N	CERRADO	CONTADO	6	0.00	0.00
8	139	2021-05-10 15:42:11.246249	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:42:11.246249	\N	\N	CERRADO	CONTADO	7	0.00	0.00
9	185	2021-05-10 15:43:55.601242	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:43:55.601242	\N	\N	CERRADO	CONTADO	8	0.00	0.00
10	72	2021-05-10 15:45:57.069863	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:45:57.069863	\N	\N	CERRADO	CONTADO	9	0.00	0.00
11	102	2021-05-10 15:46:23.726729	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:46:23.726729	\N	\N	CERRADO	CONTADO	10	0.00	0.00
12	62	2021-05-10 15:48:44.846743	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:48:44.846743	\N	\N	CERRADO	CONTADO	11	0.00	0.00
13	187	2021-05-10 15:49:09.365742	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:49:09.365742	\N	\N	CERRADO	CONTADO	12	0.00	0.00
14	19	2021-05-10 15:49:35.313126	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:49:35.313126	\N	\N	CERRADO	CONTADO	13	0.00	0.00
15	158	2021-05-10 15:49:53.967368	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:49:53.967368	\N	\N	CERRADO	CONTADO	14	0.00	0.00
16	38	2021-05-10 15:50:21.713589	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:50:21.713589	\N	\N	CERRADO	CONTADO	15	0.00	0.00
17	39	2021-05-10 15:50:44.275602	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:50:44.275602	\N	\N	CERRADO	CONTADO	16	0.00	0.00
18	240	2021-05-10 15:53:18.545102	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 15:53:18.545102	\N	\N	CERRADO	CONTADO	17	0.00	0.00
19	200	2021-05-10 15:56:43.631619	34.50	194.00	0.00	0.00	194.00	f	f	VBONILLA	2021-05-10 15:56:43.631619	\N	\N	CERRADO	CONTADO	18	0.00	0.00
20	262	2021-05-10 16:01:01.108224	34.50	300.00	0.00	0.00	300.00	f	f	VBONILLA	2021-05-10 16:01:01.108224	\N	\N	CERRADO	CONTADO	19	0.00	0.00
21	264	2021-05-10 16:13:21.717032	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 16:13:21.717032	\N	\N	CERRADO	CONTADO	20	0.00	0.00
22	263	2021-05-10 16:13:50.83656	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 16:13:50.83656	\N	\N	CERRADO	CONTADO	21	0.00	0.00
23	265	2021-05-10 16:14:27.188033	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 16:14:27.188033	\N	\N	CERRADO	CONTADO	22	0.00	0.00
24	266	2021-05-10 16:19:00.4643	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 16:19:00.4643	\N	\N	CERRADO	CONTADO	23	0.00	0.00
25	267	2021-05-10 16:24:29.012593	34.50	76.00	0.00	0.00	76.00	f	f	VBONILLA	2021-05-10 16:24:29.012593	\N	\N	CERRADO	CREDITO	24	0.00	0.00
26	47	2021-05-10 16:26:49.010295	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-10 16:26:49.010295	\N	\N	CERRADO	CREDITO	25	0.00	0.00
30	88	2021-05-11 15:35:44.115491	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-11 15:35:44.115491	\N	\N	CERRADO	CONTADO	26	0.00	0.00
31	40	2021-05-11 15:36:28.080055	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-11 15:36:28.080055	\N	\N	CERRADO	CONTADO	27	0.00	0.00
32	212	2021-05-11 15:37:10.257202	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-11 15:37:10.257202	\N	\N	CERRADO	CONTADO	28	0.00	0.00
33	200	2021-05-11 15:42:05.297856	34.50	100.00	0.00	0.00	100.00	f	f	VBONILLA	2021-05-11 15:42:05.297856	\N	\N	CERRADO	CONTADO	29	0.00	0.00
34	200	2021-05-11 15:45:02.157814	34.50	50.00	0.00	0.00	50.00	f	f	VBONILLA	2021-05-11 15:45:02.157814	\N	\N	CERRADO	CONTADO	30	0.00	0.00
35	130	2021-05-11 16:05:26.034355	34.50	54.00	0.00	0.00	54.00	f	f	VBONILLA	2021-05-11 16:05:26.034355	\N	\N	CERRADO	CONTADO	31	0.00	0.00
36	267	2021-05-11 16:28:27.408437	34.50	35.00	0.00	0.00	35.00	f	f	VBONILLA	2021-05-11 16:28:27.408437	\N	\N	CERRADO	CREDITO	32	0.00	0.00
37	47	2021-05-11 16:28:56.686437	34.50	30.00	0.00	0.00	30.00	f	f	VBONILLA	2021-05-11 16:28:56.686437	\N	\N	CERRADO	CREDITO	33	0.00	0.00
38	200	2021-05-11 16:49:13.877518	34.50	8.00	0.00	0.00	8.00	f	f	RPRAVIA	2021-05-11 16:49:13.877518	\N	\N	CERRADO	CONTADO	34	0.00	0.00
39	139	2021-05-11 17:29:49.716581	34.50	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-11 17:29:49.716581	\N	\N	CERRADO	CONTADO	35	0.00	0.00
40	263	2021-05-11 17:32:21.360917	34.50	60.00	0.00	0.00	60.00	f	f	RPRAVIA	2021-05-11 17:32:21.360917	\N	\N	CERRADO	CONTADO	36	0.00	0.00
41	102	2021-05-11 17:33:37.968171	34.50	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-11 17:33:37.968171	\N	\N	CERRADO	CONTADO	37	0.00	0.00
42	265	2021-05-11 18:03:21.906314	35.0748	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-11 18:03:21.906314	\N	\N	CERRADO	CONTADO	38	0.00	0.00
43	200	2021-05-11 18:06:42.512701	35.0748	12.00	0.00	0.00	12.00	f	f	RPRAVIA	2021-05-11 18:06:42.512701	\N	\N	CERRADO	CONTADO	39	0.00	0.00
44	240	2021-05-11 18:09:19.954336	35.0748	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-11 18:09:19.954336	\N	\N	CERRADO	CONTADO	40	0.00	0.00
45	137	2021-05-12 19:01:16.141619	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-12 19:01:16.141619	\N	\N	CERRADO	CONTADO	41	0.00	0.00
46	200	2021-05-12 19:25:01.458102	35.0767	20.00	0.00	0.00	20.00	f	f	RPRAVIA	2021-05-12 19:25:01.458102	\N	\N	CERRADO	CONTADO	42	0.00	0.00
47	200	2021-05-12 19:35:31.630468	35.0767	4.00	0.00	0.00	4.00	f	f	RPRAVIA	2021-05-12 19:35:31.630468	\N	\N	CERRADO	CONTADO	43	0.00	0.00
48	200	2021-05-12 19:36:59.574831	35.0767	15.00	0.00	0.00	15.00	f	f	RPRAVIA	2021-05-12 19:36:59.574831	\N	\N	CERRADO	CONTADO	44	0.00	0.00
49	212	2021-05-12 19:37:58.003004	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-12 19:37:58.003004	\N	\N	CERRADO	CONTADO	45	0.00	0.00
50	148	2021-05-12 19:38:46.957201	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-12 19:38:46.957201	\N	\N	CERRADO	CONTADO	46	0.00	0.00
51	231	2021-05-12 19:42:56.269233	35.0767	450.00	0.00	0.00	450.00	f	f	RPRAVIA	2021-05-12 19:42:56.269233	\N	\N	CERRADO	CONTADO	47	0.00	0.00
52	217	2021-05-12 19:43:59.890132	35.0767	450.00	0.00	0.00	450.00	f	f	RPRAVIA	2021-05-12 19:43:59.890132	\N	\N	CERRADO	CONTADO	48	0.00	0.00
53	224	2021-05-12 19:45:06.895678	35.0767	450.00	0.00	0.00	450.00	f	f	RPRAVIA	2021-05-12 19:45:06.895678	\N	\N	CERRADO	CONTADO	49	0.00	0.00
54	40	2021-05-12 19:49:16.437887	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-12 19:49:16.437887	\N	\N	CERRADO	CONTADO	50	0.00	0.00
55	200	2021-05-12 19:50:19.249495	35.0767	20.00	0.00	0.00	20.00	f	f	RPRAVIA	2021-05-12 19:50:19.249495	\N	\N	CERRADO	CONTADO	51	0.00	0.00
56	200	2021-05-12 19:51:47.794843	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-12 19:51:47.794843	\N	\N	CERRADO	CONTADO	52	0.00	0.00
57	185	2021-05-12 19:55:14.223795	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-12 19:55:14.223795	\N	\N	CERRADO	CONTADO	53	0.00	0.00
58	200	2021-05-12 19:55:52.146347	35.0767	4.00	0.00	0.00	4.00	f	f	RPRAVIA	2021-05-12 19:55:52.146347	\N	\N	CERRADO	CONTADO	54	0.00	0.00
59	130	2021-05-12 19:56:48.623672	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-12 19:56:48.623672	\N	\N	CERRADO	CONTADO	55	0.00	0.00
60	200	2021-05-12 19:57:25.740469	35.0767	15.00	0.00	0.00	15.00	f	f	RPRAVIA	2021-05-12 19:57:25.740469	\N	\N	CERRADO	CONTADO	56	0.00	0.00
61	200	2021-05-12 19:59:40.341216	35.0767	20.00	0.00	0.00	20.00	f	f	RPRAVIA	2021-05-12 19:59:40.341216	\N	\N	CERRADO	CONTADO	57	0.00	0.00
62	238	2021-05-12 20:03:01.101593	35.0767	34.00	0.00	0.00	34.00	f	f	RPRAVIA	2021-05-12 20:03:01.101593	\N	\N	CERRADO	CONTADO	58	0.00	0.00
63	90	2021-05-12 20:05:06.289035	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-12 20:05:06.289035	\N	\N	CERRADO	CONTADO	59	0.00	0.00
64	102	2021-05-12 20:08:04.36713	35.0767	34.00	0.00	0.00	34.00	f	f	RPRAVIA	2021-05-12 20:08:04.36713	\N	\N	CERRADO	CONTADO	60	0.00	0.00
65	240	2021-05-12 20:09:12.72827	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-12 20:09:12.72827	\N	\N	CERRADO	CONTADO	61	0.00	0.00
66	177	2021-05-12 20:14:30.414798	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-12 20:14:30.414798	\N	\N	CERRADO	CONTADO	62	0.00	0.00
67	158	2021-05-12 20:15:18.256212	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-12 20:15:18.256212	\N	\N	CERRADO	CONTADO	63	0.00	0.00
68	38	2021-05-12 20:16:30.323967	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-12 20:16:30.323967	\N	\N	CERRADO	CONTADO	64	0.00	0.00
69	39	2021-05-12 20:18:10.098445	35.0767	59.00	0.00	0.00	59.00	f	f	RPRAVIA	2021-05-12 20:18:10.098445	\N	\N	CERRADO	CONTADO	65	0.00	0.00
70	200	2021-05-12 20:21:12.622171	35.0767	40.00	0.00	0.00	40.00	f	f	RPRAVIA	2021-05-12 20:21:12.622171	\N	\N	CERRADO	CONTADO	66	0.00	0.00
71	137	2021-05-13 14:31:10.995961	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-13 14:31:10.995961	\N	\N	CERRADO	CONTADO	67	0.00	0.00
72	212	2021-05-13 14:32:04.021918	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-13 14:32:04.021918	\N	\N	CERRADO	CONTADO	68	0.00	0.00
73	108	2021-05-13 14:33:56.43682	35.0767	50.00	0.00	0.00	50.00	f	f	RPRAVIA	2021-05-13 14:33:56.43682	\N	\N	CERRADO	CONTADO	69	0.00	0.00
74	252	2021-05-13 14:37:58.958098	35.0767	95.00	0.00	0.00	95.00	f	f	RPRAVIA	2021-05-13 14:37:58.958098	\N	\N	CERRADO	CONTADO	70	0.00	0.00
75	133	2021-05-13 14:39:24.916182	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-13 14:39:24.916182	\N	\N	CERRADO	CONTADO	71	0.00	0.00
76	130	2021-05-13 15:53:21.453526	35.0767	70.00	0.00	0.00	70.00	f	f	RPRAVIA	2021-05-13 15:53:21.453526	\N	\N	CERRADO	CONTADO	72	0.00	0.00
77	200	2021-05-13 15:56:30.168003	35.0767	8.00	0.00	0.00	8.00	f	f	RPRAVIA	2021-05-13 15:56:30.168003	\N	\N	CERRADO	CONTADO	73	0.00	0.00
78	238	2021-05-13 16:55:44.782588	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-13 16:55:44.782588	\N	\N	CERRADO	CONTADO	74	0.00	0.00
79	263	2021-05-13 18:01:23.88762	35.0767	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-13 18:01:23.88762	\N	\N	CERRADO	CONTADO	75	0.00	0.00
80	268	2021-05-13 18:31:03.854595	35.0786	70.00	0.00	0.00	70.00	f	f	RPRAVIA	2021-05-13 18:31:03.854595	\N	\N	CERRADO	CONTADO	76	0.00	0.00
81	177	2021-05-13 18:49:19.24799	35.0786	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-13 18:49:19.24799	\N	\N	CERRADO	CONTADO	77	0.00	0.00
82	200	2021-05-13 19:08:33.166368	35.0786	19.00	0.00	0.00	19.00	f	f	RPRAVIA	2021-05-13 19:08:33.166368	\N	\N	CERRADO	CONTADO	78	0.00	0.00
83	137	2021-05-14 13:51:19.311459	35.0786	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-14 13:51:19.311459	\N	\N	CERRADO	CONTADO	79	0.00	0.00
85	40	2021-05-14 13:56:33.677459	35.0786	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-14 13:56:33.677459	\N	\N	CERRADO	CONTADO	81	0.00	0.00
86	200	2021-05-14 13:58:50.094244	35.0786	49.00	0.00	0.00	49.00	f	f	RPRAVIA	2021-05-14 13:58:50.094244	\N	\N	CERRADO	CONTADO	82	0.00	0.00
87	252	2021-05-14 14:03:22.45264	35.0786	60.00	0.00	0.00	60.00	f	f	RPRAVIA	2021-05-14 14:03:22.45264	\N	\N	CERRADO	CONTADO	83	0.00	0.00
88	148	2021-05-14 14:05:57.199397	35.0786	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-14 14:05:57.199397	\N	\N	CERRADO	CONTADO	84	0.00	0.00
89	200	2021-05-14 14:07:56.97419	35.0786	99.00	0.00	0.00	99.00	f	f	RPRAVIA	2021-05-14 14:07:56.97419	\N	\N	CERRADO	CONTADO	85	0.00	0.00
90	185	2021-05-14 15:50:16.655336	35.0786	42.00	0.00	0.00	42.00	f	f	RPRAVIA	2021-05-14 15:50:16.655336	\N	\N	CERRADO	CONTADO	86	0.00	0.00
91	238	2021-05-14 16:35:24.464135	35.0786	34.00	0.00	0.00	34.00	f	f	RPRAVIA	2021-05-14 16:35:24.464135	\N	\N	CERRADO	CONTADO	87	0.00	0.00
92	200	2021-05-14 16:36:02.28956	35.0786	15.00	0.00	0.00	15.00	f	f	RPRAVIA	2021-05-14 16:36:02.28956	\N	\N	CERRADO	CONTADO	88	0.00	0.00
93	102	2021-05-14 17:00:40.206126	35.0786	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-14 17:00:40.206126	\N	\N	CERRADO	CONTADO	89	0.00	0.00
94	240	2021-05-14 17:54:03.602969	35.0786	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-14 17:54:03.602969	\N	\N	CERRADO	CONTADO	90	0.00	0.00
95	263	2021-05-14 18:04:27.694375	35.0786	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-14 18:04:27.694375	\N	\N	CERRADO	CONTADO	91	0.00	0.00
96	268	2021-05-14 18:39:07.314491	35.0805	49.00	0.00	0.00	49.00	f	f	RPRAVIA	2021-05-14 18:39:07.314491	\N	\N	CERRADO	CONTADO	92	0.00	0.00
97	40	2021-05-15 08:12:05.550167	35.0805	80.00	0.00	0.00	80.00	f	f	RPRAVIA	2021-05-15 08:12:05.550167	\N	\N	CERRADO	CONTADO	93	0.00	0.00
98	212	2021-05-15 09:10:52.017033	35.0805	50.00	0.00	0.00	50.00	f	f	RPRAVIA	2021-05-15 09:10:52.017033	\N	\N	CERRADO	CONTADO	94	0.00	0.00
99	272	2021-05-15 11:38:56.87784	35.0805	60.00	0.00	0.00	60.00	f	f	RPRAVIA	2021-05-15 11:38:56.87784	\N	\N	CERRADO	CONTADO	95	0.00	0.00
100	137	2021-05-17 14:30:17.265305	35.0843	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-17 14:30:17.265305	\N	\N	CERRADO	CONTADO	96	0.00	0.00
101	274	2021-05-17 14:50:06.867182	35.0843	300.00	0.00	0.00	300.00	f	f	RPRAVIA	2021-05-17 14:50:06.867182	\N	\N	CERRADO	CONTADO	97	0.00	0.00
102	275	2021-05-17 14:57:47.803139	35.0843	300.00	0.00	0.00	300.00	f	f	RPRAVIA	2021-05-17 14:57:47.803139	\N	\N	CERRADO	CONTADO	98	0.00	0.00
103	218	2021-05-17 14:59:16.814963	35.0843	500.00	0.00	0.00	500.00	f	f	RPRAVIA	2021-05-17 14:59:16.814963	\N	\N	CERRADO	CONTADO	99	0.00	0.00
104	200	2021-05-17 15:01:02.286874	35.0843	8.00	0.00	0.00	8.00	f	f	RPRAVIA	2021-05-17 15:01:02.286874	\N	\N	CERRADO	CONTADO	100	0.00	0.00
105	212	2021-05-17 15:01:47.535602	35.0843	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-17 15:01:47.535602	\N	\N	CERRADO	CONTADO	101	0.00	0.00
106	148	2021-05-17 15:02:58.420817	35.0843	60.00	0.00	0.00	60.00	f	f	RPRAVIA	2021-05-17 15:02:58.420817	\N	\N	CERRADO	CONTADO	102	0.00	0.00
107	173	2021-05-17 15:04:27.216906	35.0843	59.00	0.00	0.00	59.00	f	f	RPRAVIA	2021-05-17 15:04:27.216906	\N	\N	CERRADO	CONTADO	103	0.00	0.00
109	185	2021-05-17 16:42:07.66144	35.0843	60.00	0.00	0.00	60.00	f	f	RPRAVIA	2021-05-17 16:42:07.66144	\N	\N	CERRADO	CONTADO	105	0.00	0.00
110	130	2021-05-17 16:43:57.042087	35.0843	74.00	0.00	0.00	74.00	f	f	RPRAVIA	2021-05-17 16:43:57.042087	\N	\N	CERRADO	CONTADO	106	0.00	0.00
111	139	2021-05-17 16:50:52.111964	35.0843	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-17 16:50:52.111964	\N	\N	CERRADO	CONTADO	107	0.00	0.00
112	240	2021-05-17 19:19:42.639788	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-17 19:19:42.639788	\N	\N	CERRADO	CONTADO	108	0.00	0.00
113	200	2021-05-17 19:22:13.037631	35.0862	31.00	0.00	0.00	31.00	f	f	RPRAVIA	2021-05-17 19:22:13.037631	\N	\N	CERRADO	CONTADO	109	0.00	0.00
114	102	2021-05-17 19:23:46.031464	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-17 19:23:46.031464	\N	\N	CERRADO	CONTADO	110	0.00	0.00
115	72	2021-05-17 19:25:21.549705	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-17 19:25:21.549705	\N	\N	CERRADO	CONTADO	111	0.00	0.00
116	158	2021-05-17 19:28:28.080124	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-17 19:28:28.080124	\N	\N	CERRADO	CONTADO	112	0.00	0.00
117	40	2021-05-17 19:29:20.27544	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-17 19:29:20.27544	\N	\N	CERRADO	CONTADO	113	0.00	0.00
118	245	2021-05-17 19:30:20.270321	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-17 19:30:20.270321	\N	\N	CERRADO	CONTADO	114	0.00	0.00
119	177	2021-05-17 19:32:43.504987	35.0862	55.00	0.00	0.00	55.00	f	f	RPRAVIA	2021-05-17 19:32:43.504987	\N	\N	CERRADO	CONTADO	115	0.00	0.00
120	16	2021-05-18 15:20:14.256371	35.0862	0	0.00	0.00	0.00	f	f	RPRAVIA	2021-05-18 15:20:14.256371	\N	\N	CERRADO	CREDITO	116	0.00	0.00
121	16	2021-05-18 15:24:27.224075	35.0862	70.00	0.00	0.00	70.00	f	f	RPRAVIA	2021-05-18 15:24:27.224075	\N	\N	CERRADO	CREDITO	117	0.00	0.00
122	137	2021-05-18 15:26:00.68665	35.0862	50.00	0.00	0.00	50.00	f	f	RPRAVIA	2021-05-18 15:26:00.68665	\N	\N	CERRADO	CONTADO	118	0.00	0.00
123	252	2021-05-18 15:30:18.063163	35.0862	500.00	0.00	0.00	500.00	f	f	RPRAVIA	2021-05-18 15:30:18.063163	\N	\N	CERRADO	CONTADO	119	0.00	0.00
124	200	2021-05-18 17:02:45.10528	35.0862	8.00	0.00	0.00	8.00	f	f	RPRAVIA	2021-05-18 17:02:45.10528	\N	\N	CERRADO	CONTADO	120	0.00	0.00
125	200	2021-05-18 17:04:29.566201	35.0862	8.00	0.00	0.00	8.00	f	f	RPRAVIA	2021-05-18 17:04:29.566201	\N	\N	CERRADO	CONTADO	121	0.00	0.00
126	200	2021-05-18 17:04:59.469196	35.0862	4.00	0.00	0.00	4.00	f	f	RPRAVIA	2021-05-18 17:04:59.469196	\N	\N	CERRADO	CONTADO	122	0.00	0.00
108	16	2021-05-17 15:09:37.196409	35.0843	70.00	0.00	0.00	70.00	f	f	RPRAVIA	2021-05-17 15:09:37.196409	2021-06-15 16:47:25.478383	jhonfc9011@hotmail.com	CERRADO	CREDITO	104	0.00	0.00
127	40	2021-05-18 17:08:09.1984	35.0862	65.00	0.00	0.00	65.00	f	f	RPRAVIA	2021-05-18 17:08:09.1984	\N	\N	CERRADO	CONTADO	123	0.00	0.00
128	148	2021-05-18 17:09:08.371325	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-18 17:09:08.371325	\N	\N	CERRADO	CONTADO	124	0.00	0.00
129	204	2021-05-18 17:10:45.485783	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-18 17:10:45.485783	\N	\N	CERRADO	CONTADO	125	0.00	0.00
130	108	2021-05-18 17:11:27.408759	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-18 17:11:27.408759	\N	\N	CERRADO	CONTADO	126	0.00	0.00
131	264	2021-05-18 17:12:07.565784	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-18 17:12:07.565784	\N	\N	CERRADO	CONTADO	127	0.00	0.00
132	138	2021-05-18 17:12:51.822716	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-18 17:12:51.822716	\N	\N	CERRADO	CONTADO	128	0.00	0.00
133	133	2021-05-18 17:13:32.943365	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-18 17:13:32.943365	\N	\N	CERRADO	CONTADO	129	0.00	0.00
134	75	2021-05-18 17:14:16.430958	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-18 17:14:16.430958	\N	\N	CERRADO	CONTADO	130	0.00	0.00
135	200	2021-05-18 17:15:11.469073	35.0862	19.00	0.00	0.00	19.00	f	f	RPRAVIA	2021-05-18 17:15:11.469073	\N	\N	CERRADO	CONTADO	131	0.00	0.00
136	240	2021-05-18 17:16:11.406587	35.0862	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-18 17:16:11.406587	\N	\N	CERRADO	CONTADO	132	0.00	0.00
137	276	2021-05-18 17:22:17.392107	35.0862	500.00	0.00	0.00	500.00	f	f	RPRAVIA	2021-05-18 17:22:17.392107	\N	\N	CERRADO	CONTADO	133	0.00	0.00
138	177	2021-05-18 18:11:48.463135	35.0881	55.00	0.00	0.00	55.00	f	f	RPRAVIA	2021-05-18 18:11:48.463135	\N	\N	CERRADO	CONTADO	134	0.00	0.00
139	200	2021-05-18 18:45:58.989984	35.0881	60.00	0.00	0.00	60.00	f	f	RPRAVIA	2021-05-18 18:45:58.989984	\N	\N	CERRADO	CONTADO	135	0.00	0.00
140	81	2021-05-18 19:54:08.081048	35.0881	450.00	0.00	0.00	450.00	f	f	RPRAVIA	2021-05-18 19:54:08.081048	\N	\N	CERRADO	CONTADO	136	0.00	0.00
141	101	2021-05-18 19:54:54.417238	35.0881	450.00	0.00	0.00	450.00	f	f	RPRAVIA	2021-05-18 19:54:54.417238	\N	\N	CERRADO	CONTADO	137	0.00	0.00
142	200	2021-05-18 21:01:08.300885	35.0881	29.00	0.00	0.00	29.00	f	f	VBONILLA	2021-05-18 21:01:08.300885	\N	\N	CERRADO	CONTADO	138	0.00	0.00
143	137	2021-05-19 14:21:21.682731	35.0881	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-19 14:21:21.682731	\N	\N	CERRADO	CONTADO	139	0.00	0.00
144	159	2021-05-19 14:23:20.365537	35.0881	50.00	0.00	0.00	50.00	f	f	RPRAVIA	2021-05-19 14:23:20.365537	\N	\N	CERRADO	CONTADO	140	0.00	0.00
145	40	2021-05-19 14:27:20.049236	35.0881	127.00	0.00	0.00	127.00	f	f	RPRAVIA	2021-05-19 14:27:20.049236	\N	\N	CERRADO	CONTADO	141	0.00	0.00
146	238	2021-05-19 16:56:20.176823	35.0881	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-19 16:56:20.176823	\N	\N	CERRADO	CONTADO	142	0.00	0.00
147	130	2021-05-19 16:57:01.19944	35.0881	50.00	0.00	0.00	50.00	f	f	RPRAVIA	2021-05-19 16:57:01.19944	\N	\N	CERRADO	CONTADO	143	0.00	0.00
148	72	2021-05-19 18:19:10.894128	35.09	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-19 18:19:10.894128	\N	\N	CERRADO	CONTADO	144	0.00	0.00
149	240	2021-05-19 18:19:49.679987	35.09	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-19 18:19:49.679987	\N	\N	CERRADO	CONTADO	145	0.00	0.00
150	245	2021-05-19 18:20:40.343852	35.09	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-19 18:20:40.343852	\N	\N	CERRADO	CONTADO	146	0.00	0.00
151	188	2021-05-19 18:55:35.858321	35.09	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-19 18:55:35.858321	\N	\N	CERRADO	CONTADO	147	0.00	0.00
152	177	2021-05-19 19:43:28.017037	35.09	34.00	0.00	0.00	34.00	f	f	RPRAVIA	2021-05-19 19:43:28.017037	\N	\N	CERRADO	CONTADO	148	0.00	0.00
153	137	2021-05-20 16:17:04.081103	35.09	50.00	0.00	0.00	50.00	f	f	RPRAVIA	2021-05-20 16:17:04.081103	\N	\N	CERRADO	CONTADO	149	0.00	0.00
156	200	2021-05-20 16:21:42.618612	35.09	15.00	0.00	0.00	15.00	f	f	RPRAVIA	2021-05-20 16:21:42.618612	\N	\N	CERRADO	CONTADO	152	0.00	0.00
154	159	2021-05-20 16:18:15.888321	35.09	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-20 16:18:15.888321	\N	\N	ANULADA	CONTADO	150	0.00	0.00
155	40	2021-05-20 16:18:55.930587	35.09	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-20 16:18:55.930587	\N	\N	ANULADA	CONTADO	151	0.00	0.00
157	137	2021-05-21 18:06:04.115526	35.0938	34.00	0.00	0.00	34.00	f	f	RPRAVIA	2021-05-21 18:06:04.115526	\N	\N	CERRADO	CONTADO	153	0.00	0.00
158	200	2021-05-21 18:10:01.331485	35.0938	4.00	0.00	0.00	4.00	f	f	RPRAVIA	2021-05-21 18:10:01.331485	\N	\N	CERRADO	CONTADO	154	0.00	0.00
159	200	2021-05-21 18:10:55.125295	35.0938	4.00	0.00	0.00	4.00	f	f	RPRAVIA	2021-05-21 18:10:55.125295	\N	\N	CERRADO	CONTADO	155	0.00	0.00
160	108	2021-05-21 18:12:36.239722	35.0938	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-21 18:12:36.239722	\N	\N	CERRADO	CONTADO	156	0.00	0.00
161	133	2021-05-21 18:13:16.822004	35.0938	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-21 18:13:16.822004	\N	\N	CERRADO	CONTADO	157	0.00	0.00
162	264	2021-05-21 18:14:10.516188	35.0938	30.00	0.00	0.00	30.00	f	f	RPRAVIA	2021-05-21 18:14:10.516188	\N	\N	CERRADO	CONTADO	158	0.00	0.00
163	47	2021-05-21 18:15:15.567282	35.0938	60.00	0.00	0.00	60.00	f	f	RPRAVIA	2021-05-21 18:15:15.567282	\N	\N	CERRADO	CONTADO	159	0.00	0.00
164	200	2021-05-21 18:16:11.890363	35.0938	29.00	0.00	0.00	29.00	f	f	RPRAVIA	2021-05-21 18:16:11.890363	\N	\N	CERRADO	CONTADO	160	0.00	0.00
165	200	2021-05-21 18:16:42.095981	35.0938	0	0.00	0.00	0.00	f	f	RPRAVIA	2021-05-21 18:16:42.095981	\N	\N	CERRADO	CONTADO	161	0.00	0.00
166	200	2021-05-21 18:17:52.949995	35.0938	60.00	0.00	0.00	60.00	f	f	RPRAVIA	2021-05-21 18:17:52.949995	\N	\N	CERRADO	CONTADO	162	0.00	0.00
167	200	2021-05-21 18:19:39.507528	35.0938	15.00	0.00	0.00	15.00	f	f	RPRAVIA	2021-05-21 18:19:39.507528	\N	\N	CERRADO	CONTADO	163	0.00	0.00
168	200	2021-05-21 18:20:52.270826	35.0938	15.00	0.00	0.00	15.00	f	f	RPRAVIA	2021-05-21 18:20:52.270826	\N	\N	CERRADO	CONTADO	164	0.00	0.00
169	200	2021-05-21 18:21:38.001738	35.0938	15.00	0.00	0.00	15.00	f	f	RPRAVIA	2021-05-21 18:21:38.001738	\N	\N	CERRADO	CONTADO	165	0.00	0.00
170	200	2021-05-21 18:22:12.884894	35.0938	12.00	0.00	0.00	12.00	f	f	RPRAVIA	2021-05-21 18:22:12.884894	\N	\N	CERRADO	CONTADO	166	0.00	0.00
171	130	2021-05-21 18:23:49.327648	35.0938	50.00	0.00	0.00	50.00	f	f	RPRAVIA	2021-05-21 18:23:49.327648	\N	\N	CERRADO	CONTADO	167	0.00	0.00
172	127	2021-05-21 18:26:16.212212	35.0938	300.00	0.00	0.00	300.00	f	f	RPRAVIA	2021-05-21 18:26:16.212212	\N	\N	CERRADO	CONTADO	168	0.00	0.00
173	72	2021-05-21 18:27:05.364233	35.0938	34.00	0.00	0.00	34.00	f	f	RPRAVIA	2021-05-21 18:27:05.364233	\N	\N	CERRADO	CONTADO	169	0.00	0.00
174	200	2021-05-21 18:28:15.285479	35.0938	4.00	0.00	0.00	4.00	f	f	RPRAVIA	2021-05-21 18:28:15.285479	\N	\N	CERRADO	CONTADO	170	0.00	0.00
175	200	2021-05-21 18:28:52.856591	35.0938	4.00	0.00	0.00	4.00	f	f	RPRAVIA	2021-05-21 18:28:52.856591	\N	\N	CERRADO	CONTADO	171	0.00	0.00
176	200	2021-05-25 17:50:27.219839	35.0995	29.00	0.00	0.00	29.00	f	f	RPRAVIA	2021-05-25 17:50:27.219839	\N	\N	CERRADO	CONTADO	172	0.00	0.00
84	16	2021-05-14 13:55:27.633378	35.0786	70.00	0.00	0.00	70.00	f	f	RPRAVIA	2021-05-14 13:55:27.633378	2021-06-15 09:01:07.343983	jhonfc9011@hotmail.com	CERRADO	CREDITO	80	0.00	0.00
177	177	2021-06-14 16:05:54.142241	35.1376	500.00	0.00	0.00	500.00	f	f	jhonfc9011@hotmail.com	2021-06-14 16:05:54.142241	2021-06-14 16:06:55.577474	jhonfc9011@hotmail.com	CERRADO	CREDITO	173	0.00	0.00
178	177	2021-06-20 17:28:34.737947	35.149	500.00	0.00	0.00	500.00	f	f	jhonfc9011@hotmail.com	2021-06-20 17:28:34.737947	\N	\N	ANULADA	CREDITO	174	0.00	0.00
179	177	2021-09-04 12:27:53.98857	35.2943	20.00	0.00	0.00	20.00	f	f	jhonfc9011@hotmail.com	2021-09-04 12:27:53.98857	\N	\N	PENDIENTE	CREDITO	175	0.00	0.00
180	177	2021-09-04 12:30:46.659443	35.2943	20.00	0.00	0.00	20.00	f	f	jhonfc9011@hotmail.com	2021-09-04 12:30:46.659443	\N	\N	PENDIENTE	CREDITO	176	0.00	0.00
181	177	2021-09-04 16:29:02.338038	35.2943	20.00	0.00	0.00	20.00	f	f	jhonfc9011@hotmail.com	2021-09-04 16:29:02.338038	\N	\N	PENDIENTE	CREDITO	177	0.00	0.00
182	177	2021-09-04 16:35:52.29245	35.2943	25.00	0.00	0.00	25.00	f	f	jhonfc9011@hotmail.com	2021-09-04 16:35:52.29245	2021-09-04 21:22:14.475143	jhonfc9011@hotmail.com	CERRADO	CREDITO	178	0.00	0.00
183	177	2021-09-11 21:31:07.274274	35.3077	20.00	0.00	0.00	20.00	f	f	jhonfc9011@hotmail.com	2021-09-11 21:31:07.274274	2021-09-11 21:32:40.346257	jhonfc9011@hotmail.com	CERRADO	CREDITO	179	0.00	0.00
184	177	2021-09-22 19:35:37.478469	35.3288	500.00	100.00	0.00	400.00	f	f	jhonfc9011@hotmail.com	2021-09-22 19:35:37.478469	\N	\N	CERRADO	CONTADO	180	0.20	0.00
185	177	2021-11-14 11:31:47.372257	35.4305	500.00	0.00	0.00	500.00	f	f	jhonfc9011@hotmail.com	2021-11-14 11:31:47.372257	\N	\N	CERRADO	CONTADO	181	0.00	0.00
186	21	2021-11-14 11:41:18.882773	35.4305	500.00	0.00	0.00	500.00	f	f	jhonfc9011@hotmail.com	2021-11-14 11:41:18.882773	2021-11-14 18:34:14.79253	jhonfc9011@hotmail.com	CERRADO	CREDITO	182	0.00	0.00
187	65	2021-11-14 18:36:34.062881	35.4305	500.00	0.00	0.00	500.00	f	f	jhonfc9011@hotmail.com	2021-11-14 18:36:34.062881	\N	\N	PENDIENTE	CREDITO	183	0.00	0.00
188	177	2021-11-20 12:46:20.483688	35.442	540.00	0.00	0.00	540.00	f	f	jhonfc9011@hotmail.com	2021-11-20 12:46:20.483688	\N	\N	CERRADO	CONTADO	184	0.00	0.00
189	167	2021-11-20 12:50:45.734347	35.442	100.00	0.00	0.00	100.00	f	f	jhonfc9011@hotmail.com	2021-11-20 12:50:45.734347	2021-11-20 12:52:40.542291	jhonfc9011@hotmail.com	ANULADA	CREDITO	185	0.00	0.00
190	177	2022-02-21 10:30:35.144556	35.6213	20.00	0.00	0.00	20.00	f	f	jhonfc9011@hotmail.com	2022-02-21 10:30:35.144556	\N	\N	CERRADO	CONTADO	186	0.00	0.00
191	167	2022-02-21 14:27:10.617621	35.6213	40.00	0.00	0.00	40.00	f	f	jhonfc9011@hotmail.com	2022-02-21 14:27:10.617621	\N	\N	CERRADO	CONTADO	187	0.00	0.00
192	177	2022-02-27 20:01:58.703043	35.6329	40.00	0.00	0.00	40.00	f	f	jhonfc9011@hotmail.com	2022-02-27 20:01:58.703043	2022-02-27 20:04:01.416116	jhonfc9011@hotmail.com	CERRADO	CREDITO	188	0.00	0.00
193	200	2022-03-18 23:09:25.189404	35.6697	170.00	8.50	0.00	161.50	f	f	jhonfc9011@hotmail.com	2022-03-18 23:09:25.189404	\N	\N	CERRADO	CONTADO	189	0.05	0.00
194	177	2022-03-26 21:16:01.19761	35.6851	495.00	0.00	0.00	495.00	f	f	jhonfc9011@hotmail.com	2022-03-26 21:16:01.19761	\N	\N	CERRADO	CONTADO	190	0.00	0.00
195	177	2022-03-26 21:43:00.342893	35.6851	0	0.00	0.00	0.00	f	f	jhonfc9011@hotmail.com	2022-03-26 21:43:00.342893	\N	\N	CERRADO	CONTADO	191	0.00	0.00
196	177	2022-03-26 21:43:51.345656	35.6851	40.00	2.00	0.00	38.00	f	f	jhonfc9011@hotmail.com	2022-03-26 21:43:51.345656	\N	\N	CERRADO	CONTADO	192	0.05	0.00
197	177	2022-03-26 21:51:14.551053	35.6851	20.00	0.00	3.00	23.00	f	f	jhonfc9011@hotmail.com	2022-03-26 21:51:14.551053	\N	\N	CERRADO	CONTADO	193	0.00	0.15
198	177	2022-03-27 10:39:12.338238	35.6871	60.00	3.00	8.55	65.55	f	f	jhonfc9011@hotmail.com	2022-03-27 10:39:12.338238	\N	\N	CERRADO	CONTADO	194	0.05	0.15
\.


--
-- TOC entry 2566 (class 0 OID 18821)
-- Dependencies: 210
-- Data for Name: tblcatfacturaencabezado_compra; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatfacturaencabezado_compra (intidserie, intidproveedor, datfechafactura, numtasacambio, numsubtotal, numdescuento, numiva, numtotal, bolanulado, boldevolucion, strusuariocreo, datfechacreo, datfechamodifico, strusuariomodifico, strestado, strtipo, numerofactura) FROM stdin;
3	2	2021-09-11 11:34:33.078799	35.3077	133.30	0.00	0.00	133.30	f	f	jhonfc9011@hotmail.com	2021-09-11 11:34:33.078799	\N	\N	CERRADO	CONTADO	1
4	2	2021-09-11 11:44:37.328874	35.3077	133.30	0.00	0.00	133.30	f	f	jhonfc9011@hotmail.com	2021-09-11 11:44:37.328874	\N	\N	CERRADO	CREDITO	2
5	2	2021-09-11 22:18:45.078178	35.3077	166.70	0.00	0.00	166.70	f	f	jhonfc9011@hotmail.com	2021-09-11 22:18:45.078178	\N	\N	PENDIENTE	CREDITO	3
6	2	2021-09-11 22:26:23.602765	35.3077	191.70	0.00	0.00	191.70	f	f	jhonfc9011@hotmail.com	2021-09-11 22:26:23.602765	\N	\N	PENDIENTE	CREDITO	4
7	2	2021-09-11 22:33:26.266605	35.3077	133.30	0.00	0.00	133.30	f	f	jhonfc9011@hotmail.com	2021-09-11 22:33:26.266605	\N	\N	CERRADO	CONTADO	5
8	2	2021-11-13 23:16:33.840527	35.4286	133.30	0.00	0.00	133.30	f	f	jhonfc9011@hotmail.com	2021-11-13 23:16:33.840527	\N	\N	CERRADO	CONTADO	6
9	2	2021-11-13 23:19:35.031757	35.4286	133.30	0.00	0.00	133.30	f	f	jhonfc9011@hotmail.com	2021-11-13 23:19:35.031757	\N	\N	CERRADO	CONTADO	7
10	2	2021-11-13 23:24:16.914205	35.4286	133.30	0.00	0.00	133.30	f	f	jhonfc9011@hotmail.com	2021-11-13 23:24:16.914205	\N	\N	ANULADA	CONTADO	8
11	2	2021-11-14 10:45:34.480531	35.4305	13.33	0.00	0.00	13.33	f	f	jhonfc9011@hotmail.com	2021-11-14 10:45:34.480531	\N	\N	CERRADO	CONTADO	9
12	2	2022-02-27 11:09:22.413971	35.6329	239.60	0.00	0.00	239.60	f	f	jhonfc9011@hotmail.com	2022-02-27 11:09:22.413971	\N	\N	CERRADO	CONTADO	10
13	3	2022-02-27 19:49:38.098426	35.6329	133.30	0.00	0.00	133.30	f	f	jhonfc9011@hotmail.com	2022-02-27 19:49:38.098426	2022-03-04 21:09:42.80357	jhonfc9011@hotmail.com	CERRADO	CREDITO	11
14	3	2022-03-05 13:10:10.898766	35.6445	180.00	0.00	0.00	180.00	f	f	jhonfc9011@hotmail.com	2022-03-05 13:10:10.898766	2022-03-05 13:19:46.220637	jhonfc9011@hotmail.com	CERRADO	CREDITO	12
15	2	2022-03-13 16:00:52.68171	35.66	9.19	0.00	0.00	9.19	f	f	jhonfc9011@hotmail.com	2022-03-13 16:00:52.68171	2022-03-13 16:09:00.29641	jhonfc9011@hotmail.com	ANULADA	CREDITO	13
16	3	2022-03-13 16:50:38.372371	35.66	91.90	0.00	0.00	91.90	f	f	jhonfc9011@hotmail.com	2022-03-13 16:50:38.372371	\N	\N	PENDIENTE	CREDITO	14
\.


--
-- TOC entry 2569 (class 0 OID 18833)
-- Dependencies: 213
-- Data for Name: tblcatformulariodetalle; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatformulariodetalle (idfrm, idfrmdetalle, strnombreelemento, strtipotag, bolestado) FROM stdin;
3	2	Aplicar descuento a producto	combo box	t
3	3	Aplicar impuesto a factura	combo box	t
4	4	Aplicar descuento a factura de compra	combo	t
4	5	Aplicar impuesto a factura de compra	combo box	t
3	6	Cambiar tipo de factura	combo	t
4	7	Cambiar tipo de compra	combo	t
7	8	Anular facturas	lista	t
7	9	Anular recibos	boton	t
20	10	Anular facturas	lista	t
20	11	Anular recibos	lista	t
19	12	Anular facturas	lista	t
19	13	Anular recibos	lista	t
27	14	Ingreso de ventas diarias por tipo de producto	rptventasdiarias.php	t
27	15	Cantidad de ventas diarias por tipo de producto	rptventasdiariascant.php	t
27	16	Utilidad de ventas diarias por tipo de producto	rptventasdiariasutilidad.php	t
8	17	Anular abono	boton	t
8	18	Anular compra	lista	t
\.


--
-- TOC entry 2571 (class 0 OID 18839)
-- Dependencies: 215
-- Data for Name: tblcatformularios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatformularios (idfrm, strformulario, strnombreform, bolestado, strkeymenu) FROM stdin;
1	Catalogo usuarios	consulusuario.php	t	mnu-ctrlusuario
2	Catalogo de perfiles	perfil.php	t	mnu-ctrlusuario
3	Nueva venta	nueva_venta.php	t	mnu-facturacion
4	Nueva compra	nueva_compra.php	t	mnu-compras
5	Productos	producto.php	t	mnu-catalogos
6	Clientes	clientes.php	t	mnu-catalogos
7	Administrar facturas	buscar_facturas.php	t	mnu-facturacion
8	Historial de compras	buscar_compras.php	t	mnu-compras
9	Existencias	existencias.php	t	mnu-compras
10	Cuentas	cuentas.php	t	mnu-contabilidad
11	Categorias de gastos	cat_gastos.php	t	mnu-contabilidad
12	Categorias de ingresos	cat_ingresos.php	t	mnu-contabilidad
13	Ingresos	transaccion_ingreso.php	t	mnu-contabilidad-transac
15	Transferir	transaccion_transferir.php	t	mnu-contabilidad-transac
14	Gastos	transacgasto.php	t	mnu-contabilidad-transac
16	Tipo de productos	tipoproductos.php	t	mnu-catalogos
18	Salidas	salidasproductos.php	t	mnu-inventario
19	Reporte de caja	buscar_facturas_caja.php	t	mnu-facturacion
20	Administrar recibos	buscar_recibos.php	t	mnu-facturacion
22	Listado de impuesto	impuesto.php	t	mnu-catalogos
21	Listado de descuento	descuento.php	t	mnu-catalogos
17	Tasa de cambio	tasacambio.php	t	mnu-catalogos
23	Catálogo de proveedores	proveedores.php	t	mnu-catalogos
24	General	config.php	t	mnu-configuracion
25	Listado de suscripciones	buscar_suscripciones.php	t	mnu-suscripciones
27	Catálogo de reportes	reportes.php	t	mnu-reportes
26	Ingreso de ventas diarias por tipo de producto	rptventasdiarias.php	t	rpt-reportes
28	Cantidad de ventas diarias por tipo de producto	rptventasdiariascant.php	t	rpt-reportes
\.


--
-- TOC entry 2573 (class 0 OID 18844)
-- Dependencies: 217
-- Data for Name: tblcatgastos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatgastos (intidclasgasto, strnombrecategoria, strusuariocreo, datfechacreo, strusuariomodifico, datfechamodifico, boolactivo) FROM stdin;
2	LUZ	jhonfc9011@hotmail.com	2022-02-26 06:01:09.809423	\N	\N	t
3	INTERNET	jhonfc9011@hotmail.com	2022-02-26 06:01:28.120343	\N	\N	t
4	AGUA	jhonfc9011@hotmail.com	2022-02-26 06:01:40.617598	\N	\N	t
5	RENTA LOCAL	jhonfc9011@hotmail.com	2022-02-26 06:02:20.490528	\N	\N	t
6	PAGO BANCO	jhonfc9011@hotmail.com	2022-02-26 06:03:03.932328	\N	\N	t
7	SALARIOS	jhonfc9011@hotmail.com	2022-02-26 06:03:48.963824	\N	\N	t
8	LIMPIEZA	jhonfc9011@hotmail.com	2022-02-26 06:04:03.4775	\N	\N	t
9	GASTO DE COMPRA	jhonfc9011@hotmail.com	2022-03-27 12:28:33.963846	\N	\N	t
\.


--
-- TOC entry 2575 (class 0 OID 18849)
-- Dependencies: 219
-- Data for Name: tblcatimpuesto; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tblcatimpuesto (intidimpuesto, nombre, numvalor, bolactivo)
values (1,'IVA 15 %',0.15,'t'),
       (2,'IVA 0 %',0.00,'t'),
       (3,'I.V.A 15 %',0.15,'t')
\.


--
-- TOC entry 2577 (class 0 OID 18857)
-- Dependencies: 221
-- Data for Name: tblcatingresos; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tblcatingresos (intidclasingreso, strnombrecategoria, strusuariocreo, datfechacreo, 
							 boolactivo)
values(1,'VENTAS','jhonfc9011@hotmail.com','2021-02-18 00:00:00','t')
\.


--
-- TOC entry 2579 (class 0 OID 18862)
-- Dependencies: 223
-- Data for Name: tblcatmenu; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatmenu (intidmenu, strmenu, strtipomenu, strnivelmenu, bolactivo, strhref, strclassicono) FROM stdin;
1	Control de usuarios	mnu-ctrlusuario	1	t	#	fa fa-gears  fa-fw
2	Administración	mnu-horizontal-admin	0	t	#	\N
3	Facturación	mnu-facturacion	1	t	#	fa fa-dollar
5	Compras	mnu-compras	1	t	#	fa fa-truck
4	Catalogos	mnu-catalogos	1	t	#	fa fa-th-large
6	Contabilidad catalogos	mnu-contabilidad	1	t	#	fa fa-th
7	Contabilidad trasacciones	mnu-contabilidad-transac	1	t	#	fa fa-ticket
8	Configuración	mnu-configuracion	1	t	#	fa fa-wrench
9	Inventario	mnu-inventario	1	t	#	fa  fa-cubes
10	Suscripciones	mnu-suscripciones	1	t	#	fa fa-th-list
11	Reportes	mnu-reportes	1	t	#	fa fa-bar-chart
\.


--
-- TOC entry 2581 (class 0 OID 18870)
-- Dependencies: 225
-- Data for Name: tblcatmenuperfil; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatmenuperfil (intidmenuperfil, idperfil, intidmenu, bolactivo) FROM stdin;
2	1	2	f
1	1	1	t
3	1	3	t
4	1	5	t
5	1	4	t
6	1	6	t
7	1	7	t
8	2	1	f
9	2	2	f
13	2	6	f
14	2	7	f
15	3	1	f
16	3	2	f
20	3	6	f
21	3	7	f
17	3	3	t
18	3	5	t
10	2	3	t
11	2	5	t
12	2	4	t
19	3	4	t
23	2	8	f
24	3	8	f
22	1	8	t
26	2	9	f
27	3	9	f
25	1	9	t
29	2	10	f
30	3	10	f
28	1	10	t
32	4	2	f
33	4	3	f
34	4	5	f
35	4	4	f
36	4	6	f
37	4	7	f
38	4	8	f
39	4	9	f
40	4	10	f
31	4	1	t
42	2	11	f
43	3	11	f
44	4	11	f
41	1	11	t
\.


--
-- TOC entry 2583 (class 0 OID 18875)
-- Dependencies: 227
-- Data for Name: tblcatperfilusr; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tblcatperfilusr (idperfil, strperfil, bolactivo)
VALUES (1,'ADMINISTRADOR','t'),
       (2,'CAJA','t'),
       (3,'ADMINISTRATIVO','t'),
       (4,'ASISTENTE','t')
\.


--
-- TOC entry 2585 (class 0 OID 18880)
-- Dependencies: 229
-- Data for Name: tblcatperfilusrfrm; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tblcatperfilusrfrm (idperfilusrfrm, idfrm, idperfil, bolactivo)
1	1	1	t
2	2	1	t
3	3	1	t
7	7	1	t
4	4	1	t
8	8	1	t
9	9	1	t
5	5	1	t
6	6	1	t
10	10	1	t
11	11	1	t
12	12	1	t
13	13	1	t
14	15	1	t
15	14	1	t
16	1	2	f
17	2	2	f
20	5	2	f
25	10	2	f
26	11	2	f
27	12	2	f
28	13	2	f
29	15	2	f
30	14	2	f
18	3	2	t
19	4	2	t
24	9	2	t
23	8	2	t
21	6	2	t
31	1	3	f
32	2	3	f
40	10	3	f
41	11	3	f
42	12	3	f
43	13	3	f
44	15	3	f
45	14	3	f
35	5	3	t
36	6	3	t
37	7	3	t
34	4	3	t
38	8	3	t
39	9	3	t
47	16	2	f
48	16	3	f
46	16	1	t
33	3	3	f
50	17	2	f
51	17	3	f
49	17	1	t
53	18	2	f
54	18	3	f
52	18	1	t
57	19	3	f
22	7	2	f
56	19	2	t
55	19	1	t
59	20	2	f
60	20	3	f
62	21	2	f
63	21	3	f
61	21	1	t
65	22	2	f
66	22	3	f
64	22	1	t
68	23	2	f
69	23	3	f
67	23	1	t
71	24	2	f
72	24	3	f
70	24	1	t
58	20	1	t
74	25	2	f
75	25	3	f
73	25	1	t
78	3	4	f
79	4	4	f
80	5	4	f
81	6	4	f
82	7	4	f
83	8	4	f
84	9	4	f
85	10	4	f
86	11	4	f
87	12	4	f
88	13	4	f
89	15	4	f
90	14	4	f
91	16	4	f
92	18	4	f
93	19	4	f
94	20	4	f
95	22	4	f
96	21	4	f
97	17	4	f
98	23	4	f
99	24	4	f
100	25	4	f
76	1	4	t
77	2	4	t
102	26	2	f
103	26	3	f
104	26	4	f
106	27	2	f
107	27	3	f
108	27	4	f
101	26	1	t
109	28	1	f
110	28	2	f
111	28	3	f
112	28	4	f
105	27	1	t
\.


--
-- TOC entry 2587 (class 0 OID 18885)
-- Dependencies: 231
-- Data for Name: tblcatperfilusrfrmdetalle; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatperfilusrfrmdetalle (idperfilusrfrmdetalle, idfrmdetalle, idperfil, bolactivo) FROM stdin;
3	4	1	f
4	5	1	f
7	2	2	f
8	3	2	f
9	4	2	f
10	5	2	f
12	7	2	f
13	2	3	f
14	3	3	f
15	4	3	f
16	5	3	f
17	6	3	f
18	7	3	f
1	2	1	t
2	3	1	t
5	6	1	t
11	6	2	t
20	8	3	f
21	8	2	f
23	9	3	f
24	9	2	f
25	11	2	f
26	11	3	f
28	10	2	f
29	10	3	f
31	12	3	f
32	12	2	f
34	13	3	f
35	13	2	f
19	8	1	t
6	7	1	t
30	10	1	t
27	11	1	t
22	9	1	t
33	12	1	t
36	13	1	t
37	2	4	f
38	3	4	f
39	4	4	f
40	5	4	f
41	6	4	f
42	7	4	f
43	8	4	f
44	9	4	f
45	10	4	f
46	11	4	f
47	12	4	f
48	13	4	f
49	15	2	f
50	15	3	f
51	15	4	f
53	14	2	f
54	14	3	f
55	14	4	f
56	14	1	t
52	15	1	t
57	16	2	f
58	16	3	f
59	16	4	f
60	16	1	t
62	17	2	f
63	17	3	f
64	17	4	f
66	18	2	f
67	18	3	f
68	18	4	f
61	17	1	t
65	18	1	t
\.


--
-- TOC entry 2589 (class 0 OID 18890)
-- Dependencies: 233
-- Data for Name: tblcatproductos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatproductos (intidproducto, strnombre, presentacion, strdescripcion, strfabricante, strestado, strtipo, strclasingreso, numcosto, numutilidad, numprecioventa, bolcontrolinventario, intstock, strimagenproducto, strusuariocreo, datfechacreo, strusuariomodifico, datfechamodifico, numvigencia) FROM stdin;
6	AGUA FUENTE PURA 600 ML	600 ML	AGUA PURIFICADA 600 ML	COMPAÑÍA DISTRIBUIDORA DE NICARAGUA, S. A.	t	5	VENTAS	13.33	2.67	16	t	15		vilma_bonilla@yahoo.com	2021-05-03 20:44:21.946526	\N	\N	0
7	AGUA FUENTE PURA 1000 ML	1000 ML	AGUA PURIFICADA 1000 ML	COMPAÑÍA DISTRIBUIDORA DE NICARAGUA, S. A.	t	5	VENTAS	16.67	3.33	20	t	34		vilma_bonilla@yahoo.com	2021-05-03 20:46:27.910248	\N	\N	0
9	AMINO 2222 ON - DÓSIS 3 TABLETAS	DÓSIS 3 TABLETAS	AMINO 2222	ON	t	3	VENTAS	9.19	10.81	20	t	20		vilma_bonilla@yahoo.com	2021-05-03 23:33:38.698932	\N	\N	0
10	AMINO 2222 ON - TABLETA	TABLETA	AMINO 2222	ON	t	3	VENTAS	3.06	6.94	10	t	61		vilma_bonilla@yahoo.com	2021-05-03 23:34:44.54521	\N	\N	0
11	AMINO 6000 DYMATIZE - DÓSIS 3 TABLETAS	DÓSIS 3 TABLETAS	AMINO 6000	DYMATIZE	t	3	VENTAS	6.30	13.70	20	t	148		vilma_bonilla@yahoo.com	2021-05-03 23:36:40.625804	\N	\N	0
12	AMINO 6000 DYMATIZE - TABLETA	TABLETA	AMINO 6000	DYMATIZE	t	3	VENTAS	2.10	7.90	10	t	445		vilma_bonilla@yahoo.com	2021-05-03 23:38:00.117359	vilma_bonilla@yahoo.com	2021-05-03 23:38:37.474395	0
13	AMINOS BEEF - DÓSIS 3 TABLETAS	DÓSIS 3 TABLETAS	AMINOS BEEF		t	3	VENTAS	6.83	13.17	20	t	131		vilma_bonilla@yahoo.com	2021-05-03 23:42:48.784148	\N	\N	0
14	AMINOS BEEF - TABLETA	TABLETA	AMINOS BEEF		t	3	VENTAS	2.28	7.72	10	t	394		vilma_bonilla@yahoo.com	2021-05-03 23:43:46.117944	\N	\N	0
15	AMP 365 GRIS 600ML	600 ML	AMP 365		t	2	VENTAS	18	8	26	t	3		vilma_bonilla@yahoo.com	2021-05-03 23:45:35.07825	\N	\N	0
16	AMP 365 AZUL 600ML	600 ML	AMP 365		f	2	VENTAS	18	8	26	t	0		vilma_bonilla@yahoo.com	2021-05-03 23:45:48.194052	\N	\N	0
17	ANADROX MHP - TABLETA	TABLETA	ANADROX	MHP	t	3	VENTAS	7.03	12.97	20	t	194		vilma_bonilla@yahoo.com	2021-05-03 23:47:29.69114	\N	\N	0
18	D FRUTA SANDÍA 500ML	500 ML	JUGO D FRUTA	COMPAÑÍA DISTRIBUIDORA DE NICARAGUA, S. A.	f	4	VENTAS	13.34	2.66	16	t	0		vilma_bonilla@yahoo.com	2021-05-08 16:52:02.15258	\N	\N	0
19	EAA/ BCAA - AMINO DRAGON PHARMA - DÓSIS TOMA	TOMA	BCAA	DRAGON PHARMA	f	3	VENTAS	35	5	40	t	0		vilma_bonilla@yahoo.com	2021-05-08 16:54:17.577553	vilma_bonilla@yahoo.com	2021-05-08 16:54:58.445176	0
20	ELECTROLIT FRESA 650ML	650 ML	ELECTROLIT	COMPAÑÍA DISTRIBUIDORA DE NICARAGUA, S. A.	t	4	VENTAS	86.40	23.60	110	t	2		vilma_bonilla@yahoo.com	2021-05-08 16:58:41.516465	\N	\N	0
21	ELECTROLIT NARANJA 650ML	650 ML	ELECTROLIT	COMPAÑÍA DISTRIBUIDORA DE NICARAGUA, S. A.	t	4	VENTAS	86.40	23.60	110	t	2		vilma_bonilla@yahoo.com	2021-05-08 16:59:04.393106	\N	\N	0
22	ELECTROLIT UVA 650ML	650 ML	ELECTROLIT	COMPAÑÍA DISTRIBUIDORA DE NICARAGUA, S. A.	t	4	VENTAS	86.40	23.60	110	t	2		vilma_bonilla@yahoo.com	2021-05-08 16:59:34.986102	\N	\N	0
24	GATORADE FRUIT PUNCH 600 ML	600 ML	GATORADE	PRICESMART	t	2	VENTAS	23.96	6.04	30	t	2		vilma_bonilla@yahoo.com	2021-05-08 17:08:44.873201	\N	\N	0
23	GATORADE BERRY BLUE 600 ML	600 ML	GATORADE	PRICESMART	f	2	VENTAS	23.96	6.04	30	t	0		vilma_bonilla@yahoo.com	2021-05-08 17:06:59.626358	vilma_bonilla@yahoo.com	2021-05-08 17:10:20.750287	0
25	GATORADE LEMON LIME 600 ML	600 ML	GATORADE	PRICESMART	f	2	VENTAS	23.96	6.04	30	t	0		vilma_bonilla@yahoo.com	2021-05-08 17:28:28.395318	\N	\N	0
26	GATORADE NARANJA 600 ML	600 ML	GATORADE	PRICESMART	t	2	VENTAS	23.96	6.04	30	t	2		vilma_bonilla@yahoo.com	2021-05-08 17:29:58.447056	\N	\N	0
27	GATORADE UVA 600 ML	600 ML	GATORADE	PRICESMART	t	2	VENTAS	23.96	6.04	30	t	0		vilma_bonilla@yahoo.com	2021-05-08 17:30:20.526528	\N	\N	0
28	HYDROXYCUT MUSCLETECH - CÁPSULA	CÁPSULA	HYDROXYCUT	MUSCLETECH	t	3	VENTAS	7.39	12.61	20	t	154		vilma_bonilla@yahoo.com	2021-05-08 17:33:02.509633	\N	\N	0
29	HYDROXYCUT MUSCLETECH - DÓSIS 2 CÁPSULAS	DÓSIS 2 CÁPSULAS	HYDROXYCUT	MUSCLETECH	t	3	VENTAS	14.78	15.22	30	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:05:08.011519	\N	\N	0
30	BOMBONES	UNIDAD	BOMBONES	COMPAÑÍA DISTRIBUIDORA DE NICARAGUA, S. A.	t	7	VENTAS	1.67	2.33	4	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:06:17.99642	\N	\N	0
31	PALETAS	UNIDAD	PALETAS	COMPAÑÍA DISTRIBUIDORA DE NICARAGUA, S. A.	t	7	VENTAS	1.33	2.67	4	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:07:08.585413	\N	\N	0
32	JET 600ML	600 ML	JET	COMPAÑÍA DISTRIBUIDORA DE NICARAGUA, S. A.	t	2	VENTAS	21.72	4.28	26	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:17:15.818434	\N	\N	0
33	KERNS MANZANA 330ML	330ML	JUGO KERNS	COMPAÑÍA DISTRIBUIDORA DE NICARAGUA, S. A.	t	4	VENTAS	12.53	2.47	15	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:19:02.027523	\N	\N	0
34	MONSTER AZUL 473ML	473ML	MONSTER	VARIOS	f	2	VENTAS	49	6	55	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:19:53.229425	\N	\N	0
35	MONSTER MANGO 473ML	473ML	MONSTER	VARIOS	f	2	VENTAS	53	6	59	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:20:30.188103	\N	\N	0
36	MONSTER VERDE 473ML	473ML	MONSTER	VARIOS	f	2	VENTAS	49	6	55	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:21:05.704937	\N	\N	0
37	PRE - ENTRENO APOCALYPSE - DÓSIS TOMA	TOMA	PRE - ENTRENO	APOCALYPSE	t	3	VENTAS	24.50	15.5	40	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:22:18.573207	\N	\N	0
38	PRE - ENTRENO RC - DÓSIS TOMA	TOMA	PRE - ENTRENO	RONNIE COLEMAN	f	3	VENTAS	17.5	22.5	40	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:27:09.816257	\N	\N	0
39	PROTEÍNA MASS LIBRA	LIBRA	PROTEÍNA	MASS	f	3	VENTAS	204.17	95.83	300	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:29:10.153356	\N	\N	0
40	RAPTOR 300ML	300 ML	RAPTOR	EDT	t	2	VENTAS	13.33	5.67	19	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:30:07.497068	\N	\N	0
41	RAPTOR 600ML	600 ML	RAPTOR	EDT	t	2	VENTAS	22.5	6.5	29	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:31:14.24909	\N	\N	0
42	PROTEÍNA MASS FRASCO	FRASCO 6 LIBRAS	PROTEÍNA	MASS	f	3	VENTAS	1242.5	177.5	1420	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:33:58.952754	\N	\N	0
43	TESTOSTERONA MONSTER TEST - DÓSIS 4 TABLETAS	DÓSIS 4 TABLETAS	TESTOSTERONA	MONSTER TEST	t	3	VENTAS	22.17	12.83	35	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:35:31.020543	\N	\N	0
44	TESTOSTERONA MONSTER TEST - FRASCO	FRASCO 120 TABLETAS	TESTOSTERONA	MONSTER TEST	t	3	VENTAS	665	210	875	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:38:17.322794	\N	\N	0
45	TESTOSTERONA MONSTER TEST - TABLETA	TABLETA	TESTOSTERONA	MONSTER TEST	t	3	VENTAS	5.54	4.46	10	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:40:45.610041	\N	\N	0
47	PRIX COLA 355ML	355 ML	PRIX COLA	COMPAÑÍA DISTRIBUIDORA DE NICARAGUA, S. A.	t	8	VENTAS	10	2	12	t	0		VBONILLA	2021-05-10 23:29:24.171726	\N	\N	0
3	SEMANA		SUSCRIPCIÓN SEMANAL		t	1	VENTAS	0	170	170	f	0		vilma_bonilla@yahoo.com	2021-05-03 20:20:55.097719	jhonfc9011@hotmail.com	2021-11-19 19:49:39.96328	7
4	QUINCENA		SUSCRIPCIÓN QUINCENAL		t	1	VENTAS	0	300	300	f	0		vilma_bonilla@yahoo.com	2021-05-03 20:22:34.96573	jhonfc9011@hotmail.com	2021-11-19 19:50:07.878056	15
5	MENSUALIDAD		SUSCRIPCIÓN MENSUAL		t	1	VENTAS	0	500	500	f	0		vilma_bonilla@yahoo.com	2021-05-03 20:37:50.362403	jhonfc9011@hotmail.com	2021-11-19 19:50:36.211089	30
46	TROPICAL CERO FRUTA 500ML	500 ML	JUGO TROPICAL	COMPAÑÍA DISTRIBUIDORA DE NICARAGUA, S. A.	t	4	VENTAS	21.15	3.85	25	t	0		vilma_bonilla@yahoo.com	2021-05-10 22:41:38.319088	jhonfc9011@hotmail.com	2021-05-11 14:51:01.672258	0
8	AGUA FUENTE PURA 1500 ML	1500 ML	AGUA PURIFICADA 1500 ML	COMPAÑÍA DISTRIBUIDORA DE NICARAGUA, S. A.	t	5	VENTAS	19.17	5.83	25	t	13		vilma_bonilla@yahoo.com	2021-05-03 21:49:13.303292	VBONILLA	2021-05-11 01:18:55.30652	0
50	GASEOSA PEPSI	12 ONZAS	BOTELLA	FEMSA	t	8	VENTAS	10	8	18	t	10		jhonfc9011@hotmail.com	2021-11-18 16:11:48.239071	jhonfc9011@hotmail.com	2021-11-19 09:54:12.418566	0
51	SEMANA PRUEBA		SEMANA PRUEBA		t	1	VENTAS	0.0	0	0.0	f	0		jhonfc9011@hotmail.com	2021-11-19 19:40:46.344155	jhonfc9011@hotmail.com	2021-11-19 19:48:17.166248	7
2	DIARIO		SUSCRIPCIÓN DIARIO		t	1	VENTAS	0	30	30	f	0		vilma_bonilla@yahoo.com	2021-04-26 18:54:08.758617	jhonfc9011@hotmail.com	2021-11-19 19:49:22.733246	1
48	MENSUALIDAD PROMOCIÓN MES		MENSUALIDAD CON 15% DE DESCUENTO		t	1	VENTAS	0.0	450	450	f	0		VBONILLA	2021-05-12 19:37:38.133682	jhonfc9011@hotmail.com	2021-11-19 19:51:14.835284	30
49	MENSUALIDAD PROMOCIÓN COLABORADOR		MENSUALIDAD CON 15% DE DESCUENTO		t	1	VENTAS	0.0	425	425	f	0		VBONILLA	2021-05-12 19:38:31.816806	jhonfc9011@hotmail.com	2021-11-19 19:51:41.362323	30
52	RED BULL	LATA	RED BULL	FEMSA	t	2	VENTAS	20	20	40	t	10		jhonfc9011@hotmail.com	2021-11-20 12:41:05.636932	\N	\N	0
53	ASISTIN	GALON	DESINFECTANTE DE PISO		t	6	LIMPIEZA	300	0	0.0	t	2		jhonfc9011@hotmail.com	2022-03-26 15:12:38.795298	jhonfc9011@hotmail.com	2022-03-26 15:17:15.43702	0
\.


--
-- TOC entry 2591 (class 0 OID 18898)
-- Dependencies: 235
-- Data for Name: tblcatproveedor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatproveedor (intidproveedor, strnombre_empresa, strsitioweb_empresa, strtelefono_empresa, strdirreccion_empresa, strdepartamento, strnombre_vendedor, strcorreo_vendedor, strtelefono_vendedor, strusuariocreo, datfechacreo, strusuariomodifico, datfechamodifico) FROM stdin;
2	COMPAñíA DISTRIBUIDORA DE NICARAGUA, S. A.		0		\N	CDN		0	vilma_bonilla@yahoo.com	2021-04-26 21:12:49.221927	\N	\N
3	DISTRIBUIDORA CESAR GUERRERO		0	TEST	\N	DICEGSA		82739363	jhonfc9011@hotmail.com	2021-10-17 18:11:16.110368	\N	\N
4	DISTRIBUIDARA INTERNACIONAL		0	TEST	\N	DIINSA		82739363	jhonfc9011@hotmail.com	2021-10-17 18:13:08.690864	\N	\N
5			0		\N	LA UNIVERSAL		0	jhonfc9011@hotmail.com	2021-11-07 10:35:16.13846	\N	\N
7	SALUD MAGAZINE	www.saludmagazine.com.ni	22512032	VILLA MILAGRO	\N	JACQUELINE REYES REYES	jacqui@gmail.com	83848421	jhonfc9011@hotmail.com	2021-11-07 12:46:57.586472	\N	\N
6	ITPLUS	www.itplusnic.com.ni	82739363	VILLA MILAGRO	\N	JHONNY GUTIERREZ	jhonfc9011@hotmail.com	82739363	jhonfc9011@hotmail.com	2021-11-07 12:12:53.024351	jhonfc9011@hotmail.com	2021-11-07 12:48:47.43741
\.


--
-- TOC entry 2593 (class 0 OID 18906)
-- Dependencies: 237
-- Data for Name: tblcattasacambio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcattasacambio (id, fecha, monto) FROM stdin;
1	2021-02-01	34.885
2	2021-02-02	34.8869
3	2021-02-03	34.8888
4	2021-02-04	34.8907
5	2021-02-05	34.8925
6	2021-02-06	34.8944
7	2021-02-07	34.8963
8	2021-02-08	34.8982
9	2021-02-09	34.9001
10	2021-02-10	34.902
11	2021-02-11	34.9039
12	2021-02-12	34.9058
13	2021-02-13	34.9077
14	2021-02-14	34.9096
15	2021-02-15	34.9115
16	2021-02-16	34.9134
17	2021-02-17	34.9153
18	2021-02-18	34.9172
19	2021-02-19	34.9191
20	2021-02-20	34.921
21	2021-02-21	34.9228
22	2021-02-22	34.9247
23	2021-02-23	34.9266
24	2021-02-24	34.9285
25	2021-02-25	34.9304
26	2021-02-26	34.9323
27	2021-02-27	34.9342
28	2021-02-28	34.9361
29	2021-03-01	34.938
30	2021-03-02	34.9399
31	2021-03-03	34.9418
32	2021-03-04	34.9437
33	2021-03-05	34.9456
34	2021-03-06	34.9475
35	2021-03-07	34.9494
36	2021-03-08	34.9513
37	2021-03-09	34.9532
38	2021-03-10	34.9551
39	2021-03-11	34.957
40	2021-03-12	34.9589
41	2021-03-13	34.9608
42	2021-03-14	34.9627
43	2021-03-15	34.9646
44	2021-03-16	34.9665
45	2021-03-17	34.9683
46	2021-03-18	34.9702
47	2021-03-19	34.9721
48	2021-03-20	34.974
49	2021-03-21	34.9759
50	2021-03-22	34.9778
51	2021-03-23	34.9797
52	2021-03-24	34.9816
53	2021-03-25	34.9835
54	2021-03-26	34.9854
55	2021-03-27	34.9873
56	2021-03-28	34.9892
57	2021-03-29	34.9911
58	2021-03-30	34.993
59	2021-03-31	34.9949
377	2021-06-30	35.1681
378	2021-06-12	35.1338
379	2021-06-29	35.1662
380	2021-06-21	35.151
381	2021-06-09	35.1281
382	2021-06-27	35.1624
383	2021-06-11	35.1319
384	2021-06-24	35.1567
385	2021-06-04	35.1185
386	2021-06-16	35.1414
387	2021-06-18	35.1452
388	2021-06-07	35.1243
389	2021-06-15	35.1395
390	2021-06-03	35.1166
391	2021-06-08	35.1262
392	2021-06-28	35.1643
393	2021-06-26	35.1605
394	2021-06-25	35.1586
395	2021-06-23	35.1548
396	2021-06-17	35.1433
397	2021-06-19	35.1471
398	2021-06-13	35.1357
399	2021-06-01	35.1128
400	2021-06-20	35.149
401	2021-06-14	35.1376
402	2021-06-10	35.13
403	2021-06-02	35.1147
404	2021-06-05	35.1205
405	2021-06-22	35.1529
406	2021-06-06	35.1224
106	2021-05-01	35.0538
107	2021-05-02	35.0557
108	2021-05-03	35.0576
109	2021-05-04	35.0595
110	2021-05-05	35.0614
111	2021-05-06	35.0633
112	2021-05-07	35.0652
113	2021-05-08	35.0671
114	2021-05-09	35.069
115	2021-05-10	35.0709
118	2021-05-13	35.0767
119	2021-05-14	35.0786
120	2021-05-15	35.0805
121	2021-05-16	35.0824
122	2021-05-17	35.0843
123	2021-05-18	35.0862
124	2021-05-19	35.0881
125	2021-05-20	35.09
126	2021-05-21	35.0919
127	2021-05-22	35.0938
128	2021-05-23	35.0957
129	2021-05-24	35.0976
130	2021-05-25	35.0995
131	2021-05-26	35.1014
132	2021-05-27	35.1033
133	2021-05-28	35.1052
134	2021-05-29	35.1071
135	2021-05-30	35.109
136	2021-05-31	35.1109
116	2021-05-11	34.50
117	2021-05-12	34.50
347	2021-04-08	35.0101
348	2021-04-23	35.0386
349	2021-04-13	35.0196
350	2021-04-03	35.0006
351	2021-04-24	35.0405
352	2021-04-10	35.0139
353	2021-04-19	35.031
354	2021-04-29	35.05
355	2021-04-21	35.0348
356	2021-04-05	35.0044
357	2021-04-16	35.0253
358	2021-04-11	35.0158
359	2021-04-04	35.0025
360	2021-04-02	34.9987
361	2021-04-17	35.0272
362	2021-04-27	35.0462
363	2021-04-09	35.012
364	2021-04-22	35.0367
365	2021-04-14	35.0215
366	2021-04-07	35.0082
367	2021-04-28	35.0481
368	2021-04-25	35.0424
369	2021-04-15	35.0234
370	2021-04-06	35.0063
371	2021-04-12	35.0177
372	2021-04-20	35.0329
373	2021-04-30	35.0519
374	2021-04-01	34.9968
375	2021-04-18	35.0291
376	2021-04-26	35.0443
407	2021-09-01	35.2885
408	2021-09-02	35.2904
409	2021-09-03	35.2924
410	2021-09-04	35.2943
411	2021-09-05	35.2962
412	2021-09-06	35.2981
413	2021-09-07	35.3
414	2021-09-08	35.3019
415	2021-09-09	35.3038
416	2021-09-10	35.3058
417	2021-09-11	35.3077
418	2021-09-12	35.3096
419	2021-09-13	35.3115
420	2021-09-14	35.3134
421	2021-09-15	35.3153
422	2021-09-16	35.3173
423	2021-09-17	35.3192
424	2021-09-18	35.3211
425	2021-09-19	35.323
426	2021-09-20	35.3249
427	2021-09-21	35.3268
428	2021-09-22	35.3288
429	2021-09-23	35.3307
430	2021-09-24	35.3326
431	2021-09-25	35.3345
432	2021-09-26	35.3364
433	2021-09-27	35.3383
434	2021-09-28	35.3403
435	2021-09-29	35.3422
436	2021-09-30	35.3441
437	2021-10-15	35.3729
438	2021-10-21	35.3844
439	2021-10-30	35.4017
440	2021-10-24	35.3901
441	2021-10-14	35.371
442	2021-10-08	35.3594
443	2021-10-20	35.3825
444	2021-10-01	35.346
445	2021-10-31	35.4036
446	2021-10-10	35.3633
447	2021-10-11	35.3652
448	2021-10-23	35.3882
449	2021-10-17	35.3767
450	2021-10-29	35.3997
451	2021-10-16	35.3748
452	2021-10-26	35.394
453	2021-10-09	35.3614
454	2021-10-25	35.3921
455	2021-10-13	35.369
456	2021-10-07	35.3575
457	2021-10-19	35.3805
458	2021-10-04	35.3518
459	2021-10-18	35.3786
460	2021-10-22	35.3863
461	2021-10-06	35.3556
462	2021-10-28	35.3978
463	2021-10-03	35.3498
464	2021-10-27	35.3959
465	2021-10-05	35.3537
466	2021-10-02	35.3479
467	2021-10-12	35.3671
770	2022-01-01	35.5229
771	2022-01-02	35.5248
772	2022-01-03	35.5267
773	2022-01-04	35.5287
774	2022-01-05	35.5306
775	2022-01-06	35.5325
776	2022-01-07	35.5344
777	2022-01-08	35.5364
778	2022-01-09	35.5383
779	2022-01-10	35.5402
780	2022-01-11	35.5422
781	2022-01-12	35.5441
782	2022-01-13	35.546
783	2022-01-14	35.5479
784	2022-01-15	35.5499
785	2022-01-16	35.5518
786	2022-01-17	35.5537
787	2022-01-18	35.5557
788	2022-01-19	35.5576
789	2022-01-20	35.5595
790	2022-01-21	35.5614
791	2022-01-22	35.5634
792	2022-01-23	35.5653
793	2022-01-24	35.5672
794	2022-01-25	35.5692
795	2022-01-26	35.5711
796	2022-01-27	35.573
797	2022-01-28	35.575
798	2022-01-29	35.5769
799	2022-01-30	35.5788
800	2022-01-31	35.5807
829	2022-02-06	35.5923
678	2021-11-25	35.4516
679	2021-11-09	35.4209
680	2021-11-30	35.4613
681	2021-11-14	35.4305
682	2021-11-12	35.4266
683	2021-11-20	35.442
684	2021-11-24	35.4497
685	2021-11-04	35.4113
686	2021-11-17	35.4363
687	2021-11-21	35.4439
688	2021-11-07	35.417
689	2021-11-01	35.4055
690	2021-11-27	35.4555
691	2021-11-05	35.4132
692	2021-11-16	35.4343
693	2021-11-22	35.4459
694	2021-11-13	35.4286
695	2021-11-19	35.4401
696	2021-11-18	35.4382
697	2021-11-02	35.4074
698	2021-11-08	35.419
699	2021-11-26	35.4536
700	2021-11-15	35.4324
701	2021-11-11	35.4247
702	2021-11-29	35.4593
703	2021-11-03	35.4094
704	2021-11-23	35.4478
705	2021-11-10	35.4228
706	2021-11-06	35.4151
707	2021-11-28	35.4574
830	2022-02-24	35.6271
831	2022-02-16	35.6116
832	2022-02-10	35.6001
833	2022-02-03	35.5865
834	2022-02-09	35.5981
835	2022-02-23	35.6252
836	2022-02-17	35.6136
837	2022-02-19	35.6174
838	2022-02-22	35.6232
839	2022-02-26	35.631
840	2022-02-08	35.5962
841	2022-02-18	35.6155
842	2022-02-12	35.6039
843	2022-02-21	35.6213
844	2022-02-02	35.5846
845	2022-02-05	35.5904
846	2022-02-01	35.5827
847	2022-02-07	35.5943
848	2022-02-13	35.6058
849	2022-02-20	35.6194
850	2022-02-28	35.6348
851	2022-02-11	35.602
852	2022-02-14	35.6078
853	2022-02-04	35.5885
854	2022-02-27	35.6329
855	2022-02-25	35.629
856	2022-02-15	35.6097
888	2022-03-26	35.6851
889	2022-03-29	35.6909
890	2022-03-02	35.6387
891	2022-03-13	35.66
892	2022-03-24	35.6813
893	2022-03-06	35.6464
894	2022-03-16	35.6658
895	2022-03-03	35.6406
896	2022-03-10	35.6542
897	2022-03-21	35.6755
898	2022-03-27	35.6871
899	2022-03-19	35.6716
900	2022-03-07	35.6484
901	2022-03-04	35.6426
902	2022-03-31	35.6948
903	2022-03-22	35.6774
904	2022-03-18	35.6697
905	2022-03-08	35.6503
906	2022-03-25	35.6832
907	2022-03-12	35.658
908	2022-03-15	35.6638
909	2022-03-09	35.6522
910	2022-03-20	35.6735
911	2022-03-11	35.6561
912	2022-03-14	35.6619
913	2022-03-28	35.689
914	2022-03-01	35.6368
915	2022-03-30	35.6929
916	2022-03-23	35.6793
917	2022-03-05	35.6445
918	2022-03-17	35.6677
\.


--
-- TOC entry 2595 (class 0 OID 18914)
-- Dependencies: 239
-- Data for Name: tblcattipofactura; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tblcattipofactura (intid, tipo, boolactivo)
values(1,'CONTADO','t'),
      (2,'CREDITO','t')
\.


--
-- TOC entry 2597 (class 0 OID 18919)
-- Dependencies: 241
-- Data for Name: tblcattipoproducto; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tblcattipoproducto (intidtipoproducto, strtipo, bolactivo)
VALUES (1,'SUSCRIPCIONES','t'),
       (2,'ENERGETIZANTES','t'),
	   (3,'SUPLEMENTOS','t'),
       (4,'JUGOS','t'),
       (5,'AGUA','t'),
(6,'PRODUCTOS VARIOS','t'),
(7,'DULCES','t'),
(8,'GASEOSAS','t')
\.


--
-- TOC entry 2599 (class 0 OID 18924)
-- Dependencies: 243
-- Data for Name: tblcatusuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tblcatusuario (intid, strpnombre, strsnombre, strpapellido, strsapellido, strsexo, strcorreo, stridentificacion, strdireccion, strcontacto, strusuariocreo, datfechacreo, strusuariomodifico, datfechamodifico, datfechabaja, bolactivo, strpassword, intidperfil) FROM stdin;
3	ARMANDO	JOSÉ	SÁNCHEZ	ESCOBAR	MASCULINO	ASANCHEZ	001-030477-0022M	ajseworld@hotmail.com	86567777	vilma_bonilla@yahoo.com	2021-05-03 19:41:18.186373	vilma_bonilla@yahoo.com	2021-05-10 00:00:00	\N	t	25d55ad283aa400af464c76d713c07ad	3
5	SERGIO	MARCELO	MENDOZA	ESTRADA	MASCULINO	SMENDOZA	001-250702-1033	sergioprivenica@gmail.com	8831331	vilma_bonilla@yahoo.com	2021-05-10 22:55:41.322557	vilma_bonilla@yahoo.com	2021-05-10 00:00:00	\N	t	25d55ad283aa400af464c76d713c07ad	2
2	VILMA	LOURDES	BONILLA	PÉREZ	FEMENINO	VBONILLA	001-050486-0022L	vilma_bonilla@yahoo.com	87032222	jhonfc9011@hotmail.com	2021-04-26 18:35:10.608597	vilma_bonilla@yahoo.com	2021-05-10 00:00:00	\N	t	1c852bbc78a814ce4ba72c2c47b177cc	1
4	RUTH	ESTHER	MEJÍA	MATAMOROS	FEMENINO	RPRAVIA	001-201101-1009Y	ruthpravia5@gmail.com	58880438	vilma_bonilla@yahoo.com	2021-05-10 22:54:05.035541	VBONILLA	2021-05-11 00:00:00	\N	t	6618b6f80391f10f72a40ad68f6de719	2
1	JHONNY	FRANCISCO	GUTIERREZ	GOMEZ	MASCULINO	jhonfc9011@hotmail.com	0011106900032B	VILLA MILAGRO	82739363	jhonfc9011@hotmail.com	2021-02-01 00:00:00	jhonfc9011@hotmail.com	2021-05-10 00:00:00	\N	t	827ccb0eea8a706c4c34a16891f84e7b	1
6	JACQULINE		REYES	REYES	FEMENINO	JREYES	002	VILLA MILAGRO	82739363	jhonfc9011@hotmail.com	2021-11-20 12:35:17.522063	\N	\N	\N	t	827ccb0eea8a706c4c34a16891f84e7b	4
\.


--
-- TOC entry 2601 (class 0 OID 18933)
-- Dependencies: 245
-- Data for Name: tbltempfacturadetalle; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbltempfacturadetalle (intidserie, intidproducto, numcantidad, strdescripcionproducto, numprecioventa, numsubttotal, numdescuento, numtotal, strusuariocreo, datfechacreo, numcosto) FROM stdin;
\.


--
-- TOC entry 2602 (class 0 OID 18939)
-- Dependencies: 246
-- Data for Name: tbltempfacturadetalle_compra; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbltempfacturadetalle_compra (intidserie, intidproducto, numcantidad, strdescripcionproducto, numprecioventa, numsubttotal, numdescuento, numtotal, strusuariocreo, datfechacreo, numcantbonificado) FROM stdin;
\.


--
-- TOC entry 2617 (class 0 OID 27409)
-- Dependencies: 261
-- Data for Name: tbltrnajuste; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbltrnajuste (intserieajuste, intidproducto, strmovimiento, intexistencia, intcantidadajuste, intstock, numcosto, numutilidad, numprecioventa, strusuariocreo, datfechacreo) FROM stdin;
1	50	Ajuste de inventario entrada	10	8	18	10	8	18	jhonfc9011@hotmail.com	2021-11-18 19:21:04.626084
2	50	Ajuste de inventario salida	18	6	12	10	8	18	jhonfc9011@hotmail.com	2021-11-18 19:23:52.909355
3	50	Ajuste de inventario entrada	12	6	18	10	8	18	jhonfc9011@hotmail.com	2021-11-18 19:27:31.969549
4	50	Ajuste de inventario salida	12	2	10	10	8	18	jhonfc9011@hotmail.com	2021-11-18 19:28:36.143902
5	50	Ajuste de inventario salida	10	10	0	10	8	18	jhonfc9011@hotmail.com	2021-11-18 19:31:57.988116
6	50	Ajuste de inventario entrada	0	10	10	10	8	18	jhonfc9011@hotmail.com	2021-11-19 09:54:12.523459
8	53	Ajuste de inventario entrada	2	1	3	300	0	0.0	jhonfc9011@hotmail.com	2022-03-26 15:17:15.508469
\.


--
-- TOC entry 2619 (class 0 OID 36111)
-- Dependencies: 266
-- Data for Name: tbltrnajusteinventario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbltrnajusteinventario (idreg, intidcliente, intidproducto, intexistencia, numtotal, datfecha, 
										   intcantidad, straplicacosto, strobservacion, strusuariocreo, datfechamodifico)
VALUES(1,261,24,1,23.96,'2022-02-26',1,'NO','test','jhonfc9011@hotmail.com','2022-02-26 05:57:06.491735')
\.


--
-- TOC entry 2605 (class 0 OID 18955)
-- Dependencies: 249
-- Data for Name: tbltrngastos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbltrngastos (intidreggasto, intidcuenta, intidclasgasto, strdescripcion, nummonto, datgasto, datfechacreo, usuariocreo) FROM stdin;
1	2	2	pago de luz	500	2022-02-26	2022-02-26 06:06:15.174859	jhonfc9011@hotmail.com
2	2	4	PAGO DE AGUA	600	2022-03-22	2022-03-22 22:23:19.96558	jhonfc9011@hotmail.com
3	2	7	PAGO SALARIOS	3000	2022-03-15	2022-03-22 22:24:49.619337	jhonfc9011@hotmail.com
4	2	8	PAGO  LIMPIEZA	2000	2022-03-15	2022-03-22 22:38:04.323058	jhonfc9011@hotmail.com
5	2	9	TRASNPORTE PARA VICICLETA ESTACIONARIA	500	2022-03-27	2022-03-27 12:29:32.44929	jhonfc9011@hotmail.com
\.


--
-- TOC entry 2607 (class 0 OID 18963)
-- Dependencies: 251
-- Data for Name: tbltrningresos; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbltrningresos (intidregingreso, intidcuenta, intidclasingreso, strdescripcion, nummonto, datingreso, datfechacreo, usuariocreo)
VALUES(2,	2,	1,	'Inversion',	1000,	'2022-03-22',	'2022-03-22 22:01:30.752477',	'jhonfc9011@hotmail.com')
\.


--
-- TOC entry 2609 (class 0 OID 18971)
-- Dependencies: 253
-- Data for Name: tbltrnmovimientos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbltrnmovimientos (intid, intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo, numreferencia, strreferencia) FROM stdin;
2	3	0	0	0	2021-05-10 23:59:29.362371	jhonfc9011@hotmail.com	\N	\N
373	6	0	91.90	763.60	2022-03-13 16:50:38.411057	jhonfc9011@hotmail.com	14	COMPRA
41	2	0	35.00	892.75	2021-05-11 16:28:27.430082	VBONILLA	32	VENTA
92	2	0	60.00	3828.75	2021-05-14 14:03:22.467935	RPRAVIA	83	VENTA
93	2	0	30.00	3858.75	2021-05-14 14:05:57.206683	RPRAVIA	84	VENTA
94	2	0	99.00	3957.75	2021-05-14 14:07:56.995887	RPRAVIA	85	VENTA
211	6	0	133.30	133.30	2021-09-11 22:14:52.808115	jhonfc9011@hotmail.com	2	COMPRA
365	6	0	180.00	671.70	2022-03-05 13:10:10.956048	jhonfc9011@hotmail.com	12	COMPRA
95	2	0	42.00	3999.75	2021-05-14 15:50:16.683303	RPRAVIA	86	VENTA
381	2	0	38.00	8411.12	2022-03-26 21:43:51.477171	jhonfc9011@hotmail.com	192	VENTA
29	4	0	0	0	2021-05-11 18:03:57.139274	jhonfc9011@hotmail.com	\N	\N
31	4	0	1700	1700	2021-05-11 18:05:23.728101	jhonfc9011@hotmail.com	2	DEPOSITO
125	2	0	0.00	6164.75	2021-05-18 15:20:14.280595	RPRAVIA	116	VENTA
170	2	0	0.00	9399.75	2021-05-21 18:16:42.106122	RPRAVIA	161	VENTA
96	2	0	34.00	4033.75	2021-05-14 16:35:24.476445	RPRAVIA	87	VENTA
199	5	0	20.00	20.00	2021-09-04 16:29:02.513854	jhonfc9011@hotmail.com	177	VENTA
200	5	0	25.00	45.00	2021-09-04 16:35:52.29749	jhonfc9011@hotmail.com	178	VENTA
202	5	25	0	20.00	2021-09-04 21:22:14.424047	jhonfc9011@hotmail.com	7	RECIBO
227	5	100	0	220.00	2021-11-14 12:27:11.831304	jhonfc9011@hotmail.com	11	RECIBO
97	2	0	15.00	4048.75	2021-05-14 16:36:02.298244	RPRAVIA	88	VENTA
98	2	0	30.00	4078.75	2021-05-14 17:00:40.21914	RPRAVIA	89	VENTA
99	2	0	30.00	4108.75	2021-05-14 17:54:03.616536	RPRAVIA	90	VENTA
137	2	0	30.00	7019.75	2021-05-18 17:12:51.830534	RPRAVIA	128	VENTA
212	6	0	166.70	300.00	2021-09-11 22:18:45.147025	jhonfc9011@hotmail.com	3	COMPRA
359	6	0	133.30	625.00	2022-02-27 19:49:38.117419	jhonfc9011@hotmail.com	11	COMPRA
374	2	0	161.50	12478.12	2022-03-18 23:09:25.247262	jhonfc9011@hotmail.com	189	VENTA
382	2	0	23.00	8434.12	2022-03-26 21:51:14.604119	jhonfc9011@hotmail.com	193	VENTA
138	2	0	30.00	7049.75	2021-05-18 17:13:32.95156	RPRAVIA	129	VENTA
139	2	0	30.00	7079.75	2021-05-18 17:14:16.443565	RPRAVIA	130	VENTA
140	2	0	19.00	7098.75	2021-05-18 17:15:11.476677	RPRAVIA	131	VENTA
141	2	0	30.00	7128.75	2021-05-18 17:16:11.414367	RPRAVIA	132	VENTA
142	2	0	500.00	7628.75	2021-05-18 17:22:17.406414	RPRAVIA	133	VENTA
143	2	0	55.00	7683.75	2021-05-18 18:11:48.481109	RPRAVIA	134	VENTA
144	2	0	60.00	7743.75	2021-05-18 18:45:59.026948	RPRAVIA	135	VENTA
145	2	0	450.00	8193.75	2021-05-18 19:54:08.095356	RPRAVIA	136	VENTA
146	2	0	450.00	8643.75	2021-05-18 19:54:54.431081	RPRAVIA	137	VENTA
147	2	0	29.00	8672.75	2021-05-18 21:01:08.316851	VBONILLA	138	VENTA
148	2	0	30.00	8702.75	2021-05-19 14:21:21.694492	RPRAVIA	139	VENTA
149	2	0	50.00	8752.75	2021-05-19 14:23:20.372885	RPRAVIA	140	VENTA
150	2	0	127.00	8879.75	2021-05-19 14:27:20.057351	RPRAVIA	141	VENTA
151	2	0	30.00	8909.75	2021-05-19 16:56:20.195675	RPRAVIA	142	VENTA
152	2	0	50.00	8959.75	2021-05-19 16:57:01.207089	RPRAVIA	143	VENTA
153	2	0	30.00	8989.75	2021-05-19 18:19:10.9018	RPRAVIA	144	VENTA
198	5	0	0	0	2021-09-04 12:53:01.447954	jhonfc9011@hotmail.com	\N	\N
203	6	0	0	0	2021-09-11 11:17:05.893459	jhonfc9011@hotmail.com	\N	\N
154	2	0	30.00	9019.75	2021-05-19 18:19:49.687203	RPRAVIA	145	VENTA
155	2	0	30.00	9049.75	2021-05-19 18:20:40.356563	RPRAVIA	146	VENTA
156	2	0	30.00	9079.75	2021-05-19 18:55:35.870486	RPRAVIA	147	VENTA
157	2	0	34.00	9113.75	2021-05-19 19:43:28.02941	RPRAVIA	148	VENTA
158	2	0	50.00	9163.75	2021-05-20 16:17:04.109583	RPRAVIA	149	VENTA
161	2	0	15.00	9178.75	2021-05-20 16:21:42.633065	RPRAVIA	152	VENTA
162	2	0	34.00	9212.75	2021-05-21 18:06:04.133797	RPRAVIA	153	VENTA
163	2	0	4.00	9216.75	2021-05-21 18:10:01.340699	RPRAVIA	154	VENTA
164	2	0	4.00	9220.75	2021-05-21 18:10:55.138028	RPRAVIA	155	VENTA
165	2	0	30.00	9250.75	2021-05-21 18:12:36.248045	RPRAVIA	156	VENTA
166	2	0	30.00	9280.75	2021-05-21 18:13:16.833818	RPRAVIA	157	VENTA
167	2	0	30.00	9310.75	2021-05-21 18:14:10.523949	RPRAVIA	158	VENTA
47	2	0	30.00	1080.75	2021-05-11 18:03:21.918191	RPRAVIA	38	VENTA
48	2	0	12.00	1092.75	2021-05-11 18:06:42.527185	RPRAVIA	39	VENTA
49	2	0	30.00	1122.75	2021-05-11 18:09:19.963431	RPRAVIA	40	VENTA
207	5	0	20.00	40.00	2021-09-11 21:31:07.366606	jhonfc9011@hotmail.com	179	VENTA
209	5	20	0	20.00	2021-09-11 21:32:40.307534	jhonfc9011@hotmail.com	8	RECIBO
221	5	0	500.00	520.00	2021-11-14 11:41:18.923626	jhonfc9011@hotmail.com	182	VENTA
229	5	10	0	210.00	2021-11-14 12:28:54.798265	jhonfc9011@hotmail.com	12	RECIBO
235	5	10	0	180.00	2021-11-14 12:44:03.227475	jhonfc9011@hotmail.com	15	RECIBO
241	5	10	0	150.00	2021-11-14 12:50:38.565695	jhonfc9011@hotmail.com	18	RECIBO
247	5	10	0	120.00	2021-11-14 13:20:42.081534	jhonfc9011@hotmail.com	21	RECIBO
253	5	10	0	90.00	2021-11-14 13:35:15.633563	jhonfc9011@hotmail.com	24	RECIBO
259	5	10	0	60.00	2021-11-14 18:22:08.717403	jhonfc9011@hotmail.com	27	RECIBO
265	5	10	0	30.00	2021-11-14 18:32:36.249766	jhonfc9011@hotmail.com	30	RECIBO
270	5	10	0	510.00	2021-11-14 18:38:20.118358	jhonfc9011@hotmail.com	32	RECIBO
276	5	10	0	480.00	2021-11-14 18:42:40.011609	jhonfc9011@hotmail.com	35	RECIBO
282	5	10	0	450.00	2021-11-14 18:47:11.479362	jhonfc9011@hotmail.com	38	RECIBO
288	5	10	0	420.00	2021-11-14 19:00:14.993256	jhonfc9011@hotmail.com	41	RECIBO
50	2	0	30.00	1152.75	2021-05-12 19:01:16.165886	RPRAVIA	41	VENTA
294	5	10	0	390.00	2021-11-14 19:04:30.966058	jhonfc9011@hotmail.com	44	RECIBO
51	2	0	20.00	1172.75	2021-05-12 19:25:01.4959	RPRAVIA	42	VENTA
300	5	10	0	360.00	2021-11-14 19:13:08.62759	jhonfc9011@hotmail.com	47	RECIBO
52	2	0	4.00	1176.75	2021-05-12 19:35:31.641789	RPRAVIA	43	VENTA
306	5	10	0	330.00	2021-11-14 19:27:22.998099	jhonfc9011@hotmail.com	50	RECIBO
53	2	0	15.00	1191.75	2021-05-12 19:36:59.589287	RPRAVIA	44	VENTA
312	5	10	0	300.00	2021-11-14 19:47:04.546297	jhonfc9011@hotmail.com	53	RECIBO
54	2	0	30.00	1221.75	2021-05-12 19:37:58.01163	RPRAVIA	45	VENTA
55	2	0	30.00	1251.75	2021-05-12 19:38:46.970503	RPRAVIA	46	VENTA
56	2	0	450.00	1701.75	2021-05-12 19:42:56.294425	RPRAVIA	47	VENTA
57	2	0	450.00	2151.75	2021-05-12 19:43:59.970763	RPRAVIA	48	VENTA
58	2	0	450.00	2601.75	2021-05-12 19:45:06.903195	RPRAVIA	49	VENTA
59	2	0	30.00	2631.75	2021-05-12 19:49:16.450348	RPRAVIA	50	VENTA
60	2	0	20.00	2651.75	2021-05-12 19:50:19.263814	RPRAVIA	51	VENTA
61	2	0	30.00	2681.75	2021-05-12 19:51:47.808005	RPRAVIA	52	VENTA
62	2	0	30.00	2711.75	2021-05-12 19:55:14.23178	RPRAVIA	53	VENTA
63	2	0	4.00	2715.75	2021-05-12 19:55:52.154532	RPRAVIA	54	VENTA
64	2	0	30.00	2745.75	2021-05-12 19:56:48.6432	RPRAVIA	55	VENTA
65	2	0	15.00	2760.75	2021-05-12 19:57:25.767083	RPRAVIA	56	VENTA
66	2	0	20.00	2780.75	2021-05-12 19:59:40.352669	RPRAVIA	57	VENTA
67	2	0	34.00	2814.75	2021-05-12 20:03:01.148575	RPRAVIA	58	VENTA
68	2	0	30.00	2844.75	2021-05-12 20:05:06.301166	RPRAVIA	59	VENTA
318	5	10	0	270.00	2021-11-14 19:50:46.851733	jhonfc9011@hotmail.com	56	RECIBO
69	2	0	34.00	2878.75	2021-05-12 20:08:04.390238	RPRAVIA	60	VENTA
375	2	0	1000	13478.12	2022-03-22 22:01:31.133008	jhonfc9011@hotmail.com	2	INGRESO
383	2	0	65.55	8499.67	2022-03-27 10:39:12.365227	jhonfc9011@hotmail.com	194	VENTA
70	2	0	30.00	2908.75	2021-05-12 20:09:12.747825	RPRAVIA	61	VENTA
71	2	0	30.00	2938.75	2021-05-12 20:14:30.424017	RPRAVIA	62	VENTA
168	2	0	60.00	9370.75	2021-05-21 18:15:15.577556	RPRAVIA	159	VENTA
169	2	0	29.00	9399.75	2021-05-21 18:16:11.907878	RPRAVIA	160	VENTA
171	2	0	60.00	9459.75	2021-05-21 18:17:52.958274	RPRAVIA	162	VENTA
172	2	0	15.00	9474.75	2021-05-21 18:19:39.51911	RPRAVIA	163	VENTA
173	2	0	15.00	9489.75	2021-05-21 18:20:52.279653	RPRAVIA	164	VENTA
174	2	0	15.00	9504.75	2021-05-21 18:21:38.015964	RPRAVIA	165	VENTA
213	6	0	191.70	491.70	2021-09-11 22:26:23.604393	jhonfc9011@hotmail.com	4	COMPRA
175	2	0	12.00	9516.75	2021-05-21 18:22:12.900501	RPRAVIA	166	VENTA
176	2	0	50.00	9566.75	2021-05-21 18:23:49.335938	RPRAVIA	167	VENTA
1	2	0	563.75	563.75	2021-04-26 04:10:35.306403	jhonfc9011@hotmail.com	\N	\N
223	5	100	0	420.00	2021-11-14 11:43:19.181919	jhonfc9011@hotmail.com	9	RECIBO
231	5	10	0	200.00	2021-11-14 12:35:54.902073	jhonfc9011@hotmail.com	13	RECIBO
237	5	10	0	170.00	2021-11-14 12:46:30.642727	jhonfc9011@hotmail.com	16	RECIBO
243	5	10	0	140.00	2021-11-14 12:52:11.32779	jhonfc9011@hotmail.com	19	RECIBO
249	5	10	0	110.00	2021-11-14 13:21:52.933703	jhonfc9011@hotmail.com	22	RECIBO
255	5	10	0	80.00	2021-11-14 13:36:27.440154	jhonfc9011@hotmail.com	25	RECIBO
4	2	0	500.00	1063.75	2021-05-10 15:35:14.715848	VBONILLA	1	VENTA
5	2	0	30.00	1093.75	2021-05-10 15:36:55.737892	VBONILLA	2	VENTA
42	2	0	30.00	922.75	2021-05-11 16:28:56.728522	VBONILLA	33	VENTA
43	2	0	8.00	930.75	2021-05-11 16:49:13.886959	RPRAVIA	34	VENTA
44	2	0	30.00	960.75	2021-05-11 17:29:49.727577	RPRAVIA	35	VENTA
45	2	0	60.00	1020.75	2021-05-11 17:32:21.372285	RPRAVIA	36	VENTA
46	2	0	30.00	1050.75	2021-05-11 17:33:37.975301	RPRAVIA	37	VENTA
72	2	0	30.00	2968.75	2021-05-12 20:15:18.273442	RPRAVIA	63	VENTA
73	2	0	30.00	2998.75	2021-05-12 20:16:30.333523	RPRAVIA	64	VENTA
74	2	0	59.00	3057.75	2021-05-12 20:18:10.109818	RPRAVIA	65	VENTA
75	2	0	40.00	3097.75	2021-05-12 20:21:12.628804	RPRAVIA	66	VENTA
76	2	0	30.00	3127.75	2021-05-13 14:31:11.018671	RPRAVIA	67	VENTA
77	2	0	30.00	3157.75	2021-05-13 14:32:04.044971	RPRAVIA	68	VENTA
78	2	0	50.00	3207.75	2021-05-13 14:33:56.448739	RPRAVIA	69	VENTA
79	2	0	95.00	3302.75	2021-05-13 14:37:58.976794	RPRAVIA	70	VENTA
80	2	0	30.00	3332.75	2021-05-13 14:39:24.923658	RPRAVIA	71	VENTA
81	2	0	70.00	3402.75	2021-05-13 15:53:21.469072	RPRAVIA	72	VENTA
82	2	0	8.00	3410.75	2021-05-13 15:56:30.175217	RPRAVIA	73	VENTA
83	2	0	30.00	3440.75	2021-05-13 16:55:44.789626	RPRAVIA	74	VENTA
84	2	0	30.00	3470.75	2021-05-13 18:01:23.894652	RPRAVIA	75	VENTA
85	2	0	70.00	3540.75	2021-05-13 18:31:03.87055	RPRAVIA	76	VENTA
86	2	0	30.00	3570.75	2021-05-13 18:49:19.261427	RPRAVIA	77	VENTA
87	2	0	19.00	3589.75	2021-05-13 19:08:33.178956	RPRAVIA	78	VENTA
88	2	0	30.00	3619.75	2021-05-14 13:51:19.327221	RPRAVIA	79	VENTA
89	2	0	70.00	3689.75	2021-05-14 13:55:27.647101	RPRAVIA	80	VENTA
90	2	0	30.00	3719.75	2021-05-14 13:56:33.684157	RPRAVIA	81	VENTA
91	2	0	49.00	3768.75	2021-05-14 13:58:50.107652	RPRAVIA	82	VENTA
177	2	0	300.00	9866.75	2021-05-21 18:26:16.224903	RPRAVIA	168	VENTA
178	2	0	34.00	9900.75	2021-05-21 18:27:05.374872	RPRAVIA	169	VENTA
261	5	10	0	50.00	2021-11-14 18:27:35.367085	jhonfc9011@hotmail.com	28	RECIBO
267	5	10	0	20.00	2021-11-14 18:34:14.784859	jhonfc9011@hotmail.com	31	RECIBO
272	5	10	0	500.00	2021-11-14 18:40:05.879848	jhonfc9011@hotmail.com	33	RECIBO
278	5	10	0	470.00	2021-11-14 18:43:26.006607	jhonfc9011@hotmail.com	36	RECIBO
284	5	10	0	440.00	2021-11-14 18:48:46.051952	jhonfc9011@hotmail.com	39	RECIBO
290	5	10	0	410.00	2021-11-14 19:00:58.507854	jhonfc9011@hotmail.com	42	RECIBO
296	5	10	0	380.00	2021-11-14 19:05:51.597728	jhonfc9011@hotmail.com	45	RECIBO
302	5	10	0	350.00	2021-11-14 19:22:21.497789	jhonfc9011@hotmail.com	48	RECIBO
308	5	10	0	320.00	2021-11-14 19:36:02.524196	jhonfc9011@hotmail.com	51	RECIBO
179	2	0	4.00	9904.75	2021-05-21 18:28:15.297566	RPRAVIA	170	VENTA
180	2	0	4.00	9908.75	2021-05-21 18:28:52.866996	RPRAVIA	171	VENTA
181	2	0	29.00	9937.75	2021-05-25 17:50:27.234261	RPRAVIA	172	VENTA
189	2	0	500.00	10437.75	2021-06-14 16:05:54.163364	jhonfc9011@hotmail.com	173	VENTA
190	2	0	500	10937.75	2021-06-14 16:06:55.558979	jhonfc9011@hotmail.com	2	RECIBO
191	2	0	40	10977.75	2021-06-15 09:00:59.539386	jhonfc9011@hotmail.com	3	RECIBO
192	2	0	30	11007.75	2021-06-15 09:01:07.239059	jhonfc9011@hotmail.com	4	RECIBO
193	2	0	40	11047.75	2021-06-15 16:47:10.836238	jhonfc9011@hotmail.com	5	RECIBO
376	2	600	0	12878.12	2022-03-22 22:23:20.07218	jhonfc9011@hotmail.com	2	GASTO
384	2	500	0	7999.67	2022-03-27 12:29:32.550335	jhonfc9011@hotmail.com	5	GASTO
314	5	10	0	290.00	2021-11-14 19:48:23.805293	jhonfc9011@hotmail.com	54	RECIBO
320	5	10	0	260.00	2021-11-14 19:53:35.07192	jhonfc9011@hotmail.com	57	RECIBO
326	5	10	0	230.00	2021-11-14 19:58:09.69729	jhonfc9011@hotmail.com	60	RECIBO
332	5	10	0	200.00	2021-11-14 20:01:07.47866	jhonfc9011@hotmail.com	63	RECIBO
338	5	10	0	170.00	2021-11-14 20:04:05.557426	jhonfc9011@hotmail.com	66	RECIBO
344	5	10	0	140.00	2021-11-15 11:26:04.408823	jhonfc9011@hotmail.com	69	RECIBO
362	5	40	0	120.00	2022-02-27 20:04:01.242207	jhonfc9011@hotmail.com	72	RECIBO
6	2	0	30.00	1123.75	2021-05-10 15:38:05.306176	VBONILLA	3	VENTA
364	6	133.30	0	491.70	2022-03-04 21:09:41.499168	jhonfc9011@hotmail.com	1	RECIBO_CXP
225	5	100	0	320.00	2021-11-14 12:21:28.537233	jhonfc9011@hotmail.com	10	RECIBO
233	5	10	0	190.00	2021-11-14 12:43:32.82963	jhonfc9011@hotmail.com	14	RECIBO
239	5	10	0	160.00	2021-11-14 12:48:20.283712	jhonfc9011@hotmail.com	17	RECIBO
245	5	10	0	130.00	2021-11-14 13:01:09.771532	jhonfc9011@hotmail.com	20	RECIBO
251	5	10	0	100.00	2021-11-14 13:23:27.506332	jhonfc9011@hotmail.com	23	RECIBO
257	5	10	0	70.00	2021-11-14 13:38:29.343755	jhonfc9011@hotmail.com	26	RECIBO
263	5	10	0	40.00	2021-11-14 18:30:18.528287	jhonfc9011@hotmail.com	29	RECIBO
268	5	0	500.00	520.00	2021-11-14 18:36:34.107242	jhonfc9011@hotmail.com	183	VENTA
274	5	10	0	490.00	2021-11-14 18:41:11.52028	jhonfc9011@hotmail.com	34	RECIBO
280	5	10	0	460.00	2021-11-14 18:46:09.65527	jhonfc9011@hotmail.com	37	RECIBO
286	5	10	0	430.00	2021-11-14 18:57:29.216593	jhonfc9011@hotmail.com	40	RECIBO
292	5	10	0	400.00	2021-11-14 19:03:02.200949	jhonfc9011@hotmail.com	43	RECIBO
298	5	10	0	370.00	2021-11-14 19:12:23.362661	jhonfc9011@hotmail.com	46	RECIBO
304	5	10	0	340.00	2021-11-14 19:25:54.567385	jhonfc9011@hotmail.com	49	RECIBO
310	5	10	0	310.00	2021-11-14 19:37:57.849924	jhonfc9011@hotmail.com	52	RECIBO
316	5	10	0	280.00	2021-11-14 19:49:52.305384	jhonfc9011@hotmail.com	55	RECIBO
322	5	10	0	250.00	2021-11-14 19:56:40.058061	jhonfc9011@hotmail.com	58	RECIBO
328	5	10	0	220.00	2021-11-14 19:59:11.930725	jhonfc9011@hotmail.com	61	RECIBO
334	5	10	0	190.00	2021-11-14 20:02:48.634122	jhonfc9011@hotmail.com	64	RECIBO
340	5	10	0	160.00	2021-11-15 11:23:32.233703	jhonfc9011@hotmail.com	67	RECIBO
346	5	10	0	130.00	2021-11-15 11:26:52.001299	jhonfc9011@hotmail.com	70	RECIBO
7	2	0	30.00	1153.75	2021-05-10 15:40:03.871228	VBONILLA	4	VENTA
377	2	3000	0	9878.12	2022-03-22 22:24:49.655269	jhonfc9011@hotmail.com	3	GASTO
8	2	0	30.00	1183.75	2021-05-10 15:40:35.256672	VBONILLA	5	VENTA
9	2	0	30.00	1213.75	2021-05-10 15:41:13.563344	VBONILLA	6	VENTA
10	2	0	30.00	1243.75	2021-05-10 15:42:11.254965	VBONILLA	7	VENTA
11	2	0	30.00	1273.75	2021-05-10 15:43:55.607935	VBONILLA	8	VENTA
12	2	0	30.00	1303.75	2021-05-10 15:45:57.076245	VBONILLA	9	VENTA
13	2	0	30.00	1333.75	2021-05-10 15:46:23.740042	VBONILLA	10	VENTA
14	2	0	30.00	1363.75	2021-05-10 15:48:44.853297	VBONILLA	11	VENTA
15	2	0	30.00	1393.75	2021-05-10 15:49:09.378487	VBONILLA	12	VENTA
16	2	0	30.00	1423.75	2021-05-10 15:49:35.368586	VBONILLA	13	VENTA
17	2	0	30.00	1453.75	2021-05-10 15:49:53.974299	VBONILLA	14	VENTA
18	2	0	30.00	1483.75	2021-05-10 15:50:21.724967	VBONILLA	15	VENTA
19	2	0	30.00	1513.75	2021-05-10 15:50:44.282185	VBONILLA	16	VENTA
20	2	0	30.00	1543.75	2021-05-10 15:53:18.551922	VBONILLA	17	VENTA
21	2	0	194.00	1737.75	2021-05-10 15:56:43.646197	VBONILLA	18	VENTA
22	2	0	300.00	2037.75	2021-05-10 16:01:01.226241	VBONILLA	19	VENTA
23	2	0	30.00	2067.75	2021-05-10 16:13:21.723675	VBONILLA	20	VENTA
24	2	0	30.00	2097.75	2021-05-10 16:13:50.868795	VBONILLA	21	VENTA
25	2	0	30.00	2127.75	2021-05-10 16:14:27.211948	VBONILLA	22	VENTA
26	2	0	30.00	2157.75	2021-05-10 16:19:00.472511	VBONILLA	23	VENTA
27	2	0	76.00	2233.75	2021-05-10 16:24:29.019198	VBONILLA	24	VENTA
28	2	0	30.00	2263.75	2021-05-10 16:26:49.021186	VBONILLA	25	VENTA
30	2	1700	0	563.75	2021-05-11 18:05:23.728101	jhonfc9011@hotmail.com	2	RETIRO
35	2	0	30.00	593.75	2021-05-11 15:35:44.15273	VBONILLA	26	VENTA
36	2	0	30.00	623.75	2021-05-11 15:36:28.126559	VBONILLA	27	VENTA
37	2	0	30.00	653.75	2021-05-11 15:37:10.307178	VBONILLA	28	VENTA
38	2	0	100.00	753.75	2021-05-11 15:42:05.314666	VBONILLA	29	VENTA
39	2	0	50.00	803.75	2021-05-11 15:45:02.186166	VBONILLA	30	VENTA
40	2	0	54.00	857.75	2021-05-11 16:05:26.070942	VBONILLA	31	VENTA
194	2	0	30	11077.75	2021-06-15 16:47:25.457367	jhonfc9011@hotmail.com	6	RECIBO
196	2	0	20.00	11097.75	2021-09-04 12:27:54.129458	jhonfc9011@hotmail.com	175	VENTA
197	2	0	20.00	11117.75	2021-09-04 12:30:46.772226	jhonfc9011@hotmail.com	176	VENTA
201	2	0	25	11142.75	2021-09-04 21:22:14.424047	jhonfc9011@hotmail.com	7	RECIBO
208	2	0	20	11162.75	2021-09-11 21:32:40.307534	jhonfc9011@hotmail.com	8	RECIBO
214	2	133.30	0	11029.45	2021-09-11 22:33:26.26973	jhonfc9011@hotmail.com	5	COMPRA
215	2	0	400.00	11429.45	2021-09-22 19:35:37.661719	jhonfc9011@hotmail.com	180	VENTA
216	2	133.30	0	11296.15	2021-11-13 23:16:33.933288	jhonfc9011@hotmail.com	6	COMPRA
217	2	133.30	0	11162.85	2021-11-13 23:19:35.034544	jhonfc9011@hotmail.com	7	COMPRA
219	2	13.33	0	11149.52	2021-11-14 10:45:34.595518	jhonfc9011@hotmail.com	9	COMPRA
220	2	0	500.00	11649.52	2021-11-14 11:31:47.458381	jhonfc9011@hotmail.com	181	VENTA
222	2	0	100	11749.52	2021-11-14 11:43:19.181919	jhonfc9011@hotmail.com	9	RECIBO
224	2	0	100	11849.52	2021-11-14 12:21:28.537233	jhonfc9011@hotmail.com	10	RECIBO
226	2	0	100	11949.52	2021-11-14 12:27:11.831304	jhonfc9011@hotmail.com	11	RECIBO
228	2	0	10	11959.52	2021-11-14 12:28:54.798265	jhonfc9011@hotmail.com	12	RECIBO
230	2	0	10	11969.52	2021-11-14 12:35:54.902073	jhonfc9011@hotmail.com	13	RECIBO
232	2	0	10	11979.52	2021-11-14 12:43:32.82963	jhonfc9011@hotmail.com	14	RECIBO
234	2	0	10	11989.52	2021-11-14 12:44:03.227475	jhonfc9011@hotmail.com	15	RECIBO
236	2	0	10	11999.52	2021-11-14 12:46:30.642727	jhonfc9011@hotmail.com	16	RECIBO
238	2	0	10	12009.52	2021-11-14 12:48:20.283712	jhonfc9011@hotmail.com	17	RECIBO
240	2	0	10	12019.52	2021-11-14 12:50:38.565695	jhonfc9011@hotmail.com	18	RECIBO
242	2	0	10	12029.52	2021-11-14 12:52:11.32779	jhonfc9011@hotmail.com	19	RECIBO
244	2	0	10	12039.52	2021-11-14 13:01:09.771532	jhonfc9011@hotmail.com	20	RECIBO
246	2	0	10	12049.52	2021-11-14 13:20:42.081534	jhonfc9011@hotmail.com	21	RECIBO
248	2	0	10	12059.52	2021-11-14 13:21:52.933703	jhonfc9011@hotmail.com	22	RECIBO
250	2	0	10	12069.52	2021-11-14 13:23:27.506332	jhonfc9011@hotmail.com	23	RECIBO
252	2	0	10	12079.52	2021-11-14 13:35:15.633563	jhonfc9011@hotmail.com	24	RECIBO
254	2	0	10	12089.52	2021-11-14 13:36:27.440154	jhonfc9011@hotmail.com	25	RECIBO
256	2	0	10	12099.52	2021-11-14 13:38:29.343755	jhonfc9011@hotmail.com	26	RECIBO
258	2	0	10	12109.52	2021-11-14 18:22:08.717403	jhonfc9011@hotmail.com	27	RECIBO
260	2	0	10	12119.52	2021-11-14 18:27:35.367085	jhonfc9011@hotmail.com	28	RECIBO
262	2	0	10	12129.52	2021-11-14 18:30:18.528287	jhonfc9011@hotmail.com	29	RECIBO
264	2	0	10	12139.52	2021-11-14 18:32:36.249766	jhonfc9011@hotmail.com	30	RECIBO
266	2	0	10	12149.52	2021-11-14 18:34:14.784859	jhonfc9011@hotmail.com	31	RECIBO
269	2	0	10	12159.52	2021-11-14 18:38:20.118358	jhonfc9011@hotmail.com	32	RECIBO
271	2	0	10	12169.52	2021-11-14 18:40:05.879848	jhonfc9011@hotmail.com	33	RECIBO
273	2	0	10	12179.52	2021-11-14 18:41:11.52028	jhonfc9011@hotmail.com	34	RECIBO
275	2	0	10	12189.52	2021-11-14 18:42:40.011609	jhonfc9011@hotmail.com	35	RECIBO
277	2	0	10	12199.52	2021-11-14 18:43:26.006607	jhonfc9011@hotmail.com	36	RECIBO
279	2	0	10	12209.52	2021-11-14 18:46:09.65527	jhonfc9011@hotmail.com	37	RECIBO
281	2	0	10	12219.52	2021-11-14 18:47:11.479362	jhonfc9011@hotmail.com	38	RECIBO
283	2	0	10	12229.52	2021-11-14 18:48:46.051952	jhonfc9011@hotmail.com	39	RECIBO
285	2	0	10	12239.52	2021-11-14 18:57:29.216593	jhonfc9011@hotmail.com	40	RECIBO
287	2	0	10	12249.52	2021-11-14 19:00:14.993256	jhonfc9011@hotmail.com	41	RECIBO
289	2	0	10	12259.52	2021-11-14 19:00:58.507854	jhonfc9011@hotmail.com	42	RECIBO
291	2	0	10	12269.52	2021-11-14 19:03:02.200949	jhonfc9011@hotmail.com	43	RECIBO
293	2	0	10	12279.52	2021-11-14 19:04:30.966058	jhonfc9011@hotmail.com	44	RECIBO
295	2	0	10	12289.52	2021-11-14 19:05:51.597728	jhonfc9011@hotmail.com	45	RECIBO
297	2	0	10	12299.52	2021-11-14 19:12:23.362661	jhonfc9011@hotmail.com	46	RECIBO
299	2	0	10	12309.52	2021-11-14 19:13:08.62759	jhonfc9011@hotmail.com	47	RECIBO
301	2	0	10	12319.52	2021-11-14 19:22:21.497789	jhonfc9011@hotmail.com	48	RECIBO
303	2	0	10	12329.52	2021-11-14 19:25:54.567385	jhonfc9011@hotmail.com	49	RECIBO
305	2	0	10	12339.52	2021-11-14 19:27:22.998099	jhonfc9011@hotmail.com	50	RECIBO
307	2	0	10	12349.52	2021-11-14 19:36:02.524196	jhonfc9011@hotmail.com	51	RECIBO
309	2	0	10	12359.52	2021-11-14 19:37:57.849924	jhonfc9011@hotmail.com	52	RECIBO
311	2	0	10	12369.52	2021-11-14 19:47:04.546297	jhonfc9011@hotmail.com	53	RECIBO
313	2	0	10	12379.52	2021-11-14 19:48:23.805293	jhonfc9011@hotmail.com	54	RECIBO
315	2	0	10	12389.52	2021-11-14 19:49:52.305384	jhonfc9011@hotmail.com	55	RECIBO
317	2	0	10	12399.52	2021-11-14 19:50:46.851733	jhonfc9011@hotmail.com	56	RECIBO
319	2	0	10	12409.52	2021-11-14 19:53:35.07192	jhonfc9011@hotmail.com	57	RECIBO
321	2	0	10	12419.52	2021-11-14 19:56:40.058061	jhonfc9011@hotmail.com	58	RECIBO
323	2	0	10	12429.52	2021-11-14 19:57:34.088892	jhonfc9011@hotmail.com	59	RECIBO
325	2	0	10	12439.52	2021-11-14 19:58:09.69729	jhonfc9011@hotmail.com	60	RECIBO
327	2	0	10	12449.52	2021-11-14 19:59:11.930725	jhonfc9011@hotmail.com	61	RECIBO
329	2	0	10	12459.52	2021-11-14 20:00:23.269081	jhonfc9011@hotmail.com	62	RECIBO
331	2	0	10	12469.52	2021-11-14 20:01:07.47866	jhonfc9011@hotmail.com	63	RECIBO
333	2	0	10	12479.52	2021-11-14 20:02:48.634122	jhonfc9011@hotmail.com	64	RECIBO
378	2	2000	0	7878.12	2022-03-22 22:38:04.336605	jhonfc9011@hotmail.com	4	GASTO
324	5	10	0	240.00	2021-11-14 19:57:34.088892	jhonfc9011@hotmail.com	59	RECIBO
330	5	10	0	210.00	2021-11-14 20:00:23.269081	jhonfc9011@hotmail.com	62	RECIBO
336	5	10	0	180.00	2021-11-14 20:03:20.493761	jhonfc9011@hotmail.com	65	RECIBO
100	2	0	30.00	4138.75	2021-05-14 18:04:27.731268	RPRAVIA	91	VENTA
101	2	0	49.00	4187.75	2021-05-14 18:39:07.361798	RPRAVIA	92	VENTA
102	2	0	80.00	4267.75	2021-05-15 08:12:05.566556	RPRAVIA	93	VENTA
103	2	0	50.00	4317.75	2021-05-15 09:10:52.064873	RPRAVIA	94	VENTA
104	2	0	60.00	4377.75	2021-05-15 11:38:56.968799	RPRAVIA	95	VENTA
105	2	0	30.00	4407.75	2021-05-17 14:30:17.284706	RPRAVIA	96	VENTA
106	2	0	300.00	4707.75	2021-05-17 14:50:06.882647	RPRAVIA	97	VENTA
107	2	0	300.00	5007.75	2021-05-17 14:57:47.818157	RPRAVIA	98	VENTA
108	2	0	500.00	5507.75	2021-05-17 14:59:16.844307	RPRAVIA	99	VENTA
109	2	0	8.00	5515.75	2021-05-17 15:01:02.299712	RPRAVIA	100	VENTA
110	2	0	30.00	5545.75	2021-05-17 15:01:47.550409	RPRAVIA	101	VENTA
111	2	0	60.00	5605.75	2021-05-17 15:02:58.432218	RPRAVIA	102	VENTA
112	2	0	59.00	5664.75	2021-05-17 15:04:27.229181	RPRAVIA	103	VENTA
113	2	0	70.00	5734.75	2021-05-17 15:09:37.223177	RPRAVIA	104	VENTA
114	2	0	60.00	5794.75	2021-05-17 16:42:07.673156	RPRAVIA	105	VENTA
115	2	0	74.00	5868.75	2021-05-17 16:43:57.062246	RPRAVIA	106	VENTA
116	2	0	30.00	5898.75	2021-05-17 16:50:52.126072	RPRAVIA	107	VENTA
117	2	0	30.00	5928.75	2021-05-17 19:19:42.656774	RPRAVIA	108	VENTA
118	2	0	31.00	5959.75	2021-05-17 19:22:13.04963	RPRAVIA	109	VENTA
119	2	0	30.00	5989.75	2021-05-17 19:23:46.04759	RPRAVIA	110	VENTA
120	2	0	30.00	6019.75	2021-05-17 19:25:21.566408	RPRAVIA	111	VENTA
121	2	0	30.00	6049.75	2021-05-17 19:28:28.087255	RPRAVIA	112	VENTA
122	2	0	30.00	6079.75	2021-05-17 19:29:20.288563	RPRAVIA	113	VENTA
123	2	0	30.00	6109.75	2021-05-17 19:30:20.289739	RPRAVIA	114	VENTA
124	2	0	55.00	6164.75	2021-05-17 19:32:43.516727	RPRAVIA	115	VENTA
126	2	0	70.00	6234.75	2021-05-18 15:24:27.269937	RPRAVIA	117	VENTA
127	2	0	50.00	6284.75	2021-05-18 15:26:00.698761	RPRAVIA	118	VENTA
128	2	0	500.00	6784.75	2021-05-18 15:30:18.081929	RPRAVIA	119	VENTA
129	2	0	8.00	6792.75	2021-05-18 17:02:45.118552	RPRAVIA	120	VENTA
130	2	0	8.00	6800.75	2021-05-18 17:04:29.598462	RPRAVIA	121	VENTA
131	2	0	4.00	6804.75	2021-05-18 17:04:59.478758	RPRAVIA	122	VENTA
132	2	0	65.00	6869.75	2021-05-18 17:08:09.20937	RPRAVIA	123	VENTA
133	2	0	30.00	6899.75	2021-05-18 17:09:08.387849	RPRAVIA	124	VENTA
134	2	0	30.00	6929.75	2021-05-18 17:10:45.494739	RPRAVIA	125	VENTA
135	2	0	30.00	6959.75	2021-05-18 17:11:27.417573	RPRAVIA	126	VENTA
136	2	0	30.00	6989.75	2021-05-18 17:12:07.5731	RPRAVIA	127	VENTA
342	5	10	0	150.00	2021-11-15 11:25:38.053959	jhonfc9011@hotmail.com	68	RECIBO
348	5	10	0	120.00	2021-11-15 11:27:19.617431	jhonfc9011@hotmail.com	71	RECIBO
360	5	0	40.00	160.00	2022-02-27 20:01:58.783759	jhonfc9011@hotmail.com	188	VENTA
379	2	0	495.00	8373.12	2022-03-26 21:16:01.271687	jhonfc9011@hotmail.com	190	VENTA
335	2	0	10	12489.52	2021-11-14 20:03:20.493761	jhonfc9011@hotmail.com	65	RECIBO
337	2	0	10	12499.52	2021-11-14 20:04:05.557426	jhonfc9011@hotmail.com	66	RECIBO
339	2	0	10	12509.52	2021-11-15 11:23:32.233703	jhonfc9011@hotmail.com	67	RECIBO
341	2	0	10	12519.52	2021-11-15 11:25:38.053959	jhonfc9011@hotmail.com	68	RECIBO
343	2	0	10	12529.52	2021-11-15 11:26:04.408823	jhonfc9011@hotmail.com	69	RECIBO
345	2	0	10	12539.52	2021-11-15 11:26:52.001299	jhonfc9011@hotmail.com	70	RECIBO
380	2	0	0.00	8373.12	2022-03-26 21:43:00.405663	jhonfc9011@hotmail.com	191	VENTA
347	2	0	10	12549.52	2021-11-15 11:27:19.617431	jhonfc9011@hotmail.com	71	RECIBO
351	2	0	540.00	13089.52	2021-11-20 12:46:20.525241	jhonfc9011@hotmail.com	184	VENTA
355	2	0	20.00	13109.52	2022-02-21 10:30:35.437604	jhonfc9011@hotmail.com	186	VENTA
356	2	0	40.00	13149.52	2022-02-21 14:27:10.662254	jhonfc9011@hotmail.com	187	VENTA
357	2	500	0	12649.52	2022-02-26 06:06:15.217713	jhonfc9011@hotmail.com	1	GASTO
358	2	239.60	0	12409.92	2022-02-27 11:09:24.005987	jhonfc9011@hotmail.com	10	COMPRA
361	2	0	40	12449.92	2022-02-27 20:04:01.242207	jhonfc9011@hotmail.com	72	RECIBO
363	2	133.30	0	12316.62	2022-03-04 21:09:41.499168	jhonfc9011@hotmail.com	1	RECIBO_CXP
\.


--
-- TOC entry 2611 (class 0 OID 18979)
-- Dependencies: 255
-- Data for Name: tbltrnpagos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbltrnpagos (intnumdocumento, numerofactura, intserie, datfecha, intidcliente, numtotal_cobrado, strobservacion, datfechacreo, strusuariocreo, datfechamodifico, strusuariomodifico) FROM stdin;
2	173	1	2021-06-14	177	500		2021-06-14 16:06:55.558979	jhonfc9011@hotmail.com	\N	\N
3	80	1	2021-06-15	16	40		2021-06-15 09:00:59.539386	jhonfc9011@hotmail.com	\N	\N
4	80	2	2021-06-15	16	30		2021-06-15 09:01:07.239059	jhonfc9011@hotmail.com	\N	\N
5	104	1	2021-06-15	16	40		2021-06-15 16:47:10.836238	jhonfc9011@hotmail.com	\N	\N
6	104	2	2021-06-15	16	30		2021-06-15 16:47:25.457367	jhonfc9011@hotmail.com	\N	\N
7	178	1	2021-09-04	177	25		2021-09-04 21:22:14.424047	jhonfc9011@hotmail.com	\N	\N
8	179	1	2021-09-11	177	20	TEST	2021-09-11 21:32:40.307534	jhonfc9011@hotmail.com	\N	\N
9	182	1	2021-11-14	21	100		2021-11-14 11:43:19.181919	jhonfc9011@hotmail.com	\N	\N
10	182	2	2021-11-14	21	100		2021-11-14 12:21:28.537233	jhonfc9011@hotmail.com	\N	\N
11	182	3	2021-11-14	21	100		2021-11-14 12:27:11.831304	jhonfc9011@hotmail.com	\N	\N
12	182	4	2021-11-14	21	10		2021-11-14 12:28:54.798265	jhonfc9011@hotmail.com	\N	\N
13	182	5	2021-11-14	21	10		2021-11-14 12:35:54.902073	jhonfc9011@hotmail.com	\N	\N
14	182	6	2021-11-14	21	10		2021-11-14 12:43:32.82963	jhonfc9011@hotmail.com	\N	\N
15	182	7	2021-11-14	21	10		2021-11-14 12:44:03.227475	jhonfc9011@hotmail.com	\N	\N
16	182	8	2021-11-14	21	10		2021-11-14 12:46:30.642727	jhonfc9011@hotmail.com	\N	\N
17	182	9	2021-11-14	21	10		2021-11-14 12:48:20.283712	jhonfc9011@hotmail.com	\N	\N
18	182	10	2021-11-14	21	10		2021-11-14 12:50:38.565695	jhonfc9011@hotmail.com	\N	\N
19	182	11	2021-11-14	21	10		2021-11-14 12:52:11.32779	jhonfc9011@hotmail.com	\N	\N
20	182	12	2021-11-14	21	10		2021-11-14 13:01:09.771532	jhonfc9011@hotmail.com	\N	\N
21	182	13	2021-11-14	21	10		2021-11-14 13:20:42.081534	jhonfc9011@hotmail.com	\N	\N
22	182	14	2021-11-14	21	10		2021-11-14 13:21:52.933703	jhonfc9011@hotmail.com	\N	\N
23	182	15	2021-11-14	21	10		2021-11-14 13:23:27.506332	jhonfc9011@hotmail.com	\N	\N
24	182	16	2021-11-14	21	10		2021-11-14 13:35:15.633563	jhonfc9011@hotmail.com	\N	\N
25	182	17	2021-11-14	21	10		2021-11-14 13:36:27.440154	jhonfc9011@hotmail.com	\N	\N
26	182	18	2021-11-14	21	10		2021-11-14 13:38:29.343755	jhonfc9011@hotmail.com	\N	\N
27	182	19	2021-11-14	21	10		2021-11-14 18:22:08.717403	jhonfc9011@hotmail.com	\N	\N
28	182	20	2021-11-14	21	10		2021-11-14 18:27:35.367085	jhonfc9011@hotmail.com	\N	\N
29	182	21	2021-11-14	21	10		2021-11-14 18:30:18.528287	jhonfc9011@hotmail.com	\N	\N
30	182	22	2021-11-14	21	10		2021-11-14 18:32:36.249766	jhonfc9011@hotmail.com	\N	\N
31	182	23	2021-11-14	21	10		2021-11-14 18:34:14.784859	jhonfc9011@hotmail.com	\N	\N
32	183	1	2021-11-14	65	10		2021-11-14 18:38:20.118358	jhonfc9011@hotmail.com	\N	\N
33	183	2	2021-11-14	65	10		2021-11-14 18:40:05.879848	jhonfc9011@hotmail.com	\N	\N
34	183	3	2021-11-14	65	10		2021-11-14 18:41:11.52028	jhonfc9011@hotmail.com	\N	\N
35	183	4	2021-11-14	65	10		2021-11-14 18:42:40.011609	jhonfc9011@hotmail.com	\N	\N
36	183	5	2021-11-14	65	10		2021-11-14 18:43:26.006607	jhonfc9011@hotmail.com	\N	\N
37	183	6	2021-11-14	65	10		2021-11-14 18:46:09.65527	jhonfc9011@hotmail.com	\N	\N
38	183	7	2021-11-14	65	10		2021-11-14 18:47:11.479362	jhonfc9011@hotmail.com	\N	\N
39	183	8	2021-11-14	65	10		2021-11-14 18:48:46.051952	jhonfc9011@hotmail.com	\N	\N
40	183	9	2021-11-14	65	10		2021-11-14 18:57:29.216593	jhonfc9011@hotmail.com	\N	\N
41	183	10	2021-11-14	65	10		2021-11-14 19:00:14.993256	jhonfc9011@hotmail.com	\N	\N
42	183	11	2021-11-14	65	10		2021-11-14 19:00:58.507854	jhonfc9011@hotmail.com	\N	\N
43	183	12	2021-11-14	65	10		2021-11-14 19:03:02.200949	jhonfc9011@hotmail.com	\N	\N
44	183	13	2021-11-14	65	10		2021-11-14 19:04:30.966058	jhonfc9011@hotmail.com	\N	\N
45	183	14	2021-11-14	65	10		2021-11-14 19:05:51.597728	jhonfc9011@hotmail.com	\N	\N
46	183	15	2021-11-14	65	10		2021-11-14 19:12:23.362661	jhonfc9011@hotmail.com	\N	\N
47	183	16	2021-11-14	65	10		2021-11-14 19:13:08.62759	jhonfc9011@hotmail.com	\N	\N
48	183	17	2021-11-14	65	10		2021-11-14 19:22:21.497789	jhonfc9011@hotmail.com	\N	\N
49	183	18	2021-11-14	65	10		2021-11-14 19:25:54.567385	jhonfc9011@hotmail.com	\N	\N
50	183	19	2021-11-14	65	10		2021-11-14 19:27:22.998099	jhonfc9011@hotmail.com	\N	\N
51	183	20	2021-11-14	65	10		2021-11-14 19:36:02.524196	jhonfc9011@hotmail.com	\N	\N
52	183	21	2021-11-14	65	10		2021-11-14 19:37:57.849924	jhonfc9011@hotmail.com	\N	\N
53	183	22	2021-11-14	65	10		2021-11-14 19:47:04.546297	jhonfc9011@hotmail.com	\N	\N
54	183	23	2021-11-14	65	10		2021-11-14 19:48:23.805293	jhonfc9011@hotmail.com	\N	\N
55	183	24	2021-11-14	65	10		2021-11-14 19:49:52.305384	jhonfc9011@hotmail.com	\N	\N
56	183	25	2021-11-14	65	10		2021-11-14 19:50:46.851733	jhonfc9011@hotmail.com	\N	\N
57	183	26	2021-11-14	65	10		2021-11-14 19:53:35.07192	jhonfc9011@hotmail.com	\N	\N
58	183	27	2021-11-14	65	10		2021-11-14 19:56:40.058061	jhonfc9011@hotmail.com	\N	\N
59	183	28	2021-11-14	65	10		2021-11-14 19:57:34.088892	jhonfc9011@hotmail.com	\N	\N
60	183	29	2021-11-14	65	10		2021-11-14 19:58:09.69729	jhonfc9011@hotmail.com	\N	\N
61	183	30	2021-11-14	65	10		2021-11-14 19:59:11.930725	jhonfc9011@hotmail.com	\N	\N
62	183	31	2021-11-14	65	10		2021-11-14 20:00:23.269081	jhonfc9011@hotmail.com	\N	\N
63	183	32	2021-11-14	65	10		2021-11-14 20:01:07.47866	jhonfc9011@hotmail.com	\N	\N
64	183	33	2021-11-14	65	10		2021-11-14 20:02:48.634122	jhonfc9011@hotmail.com	\N	\N
65	183	34	2021-11-14	65	10		2021-11-14 20:03:20.493761	jhonfc9011@hotmail.com	\N	\N
66	183	35	2021-11-14	65	10		2021-11-14 20:04:05.557426	jhonfc9011@hotmail.com	\N	\N
67	183	36	2021-11-15	65	10		2021-11-15 11:23:32.233703	jhonfc9011@hotmail.com	\N	\N
68	183	37	2021-11-15	65	10		2021-11-15 11:25:38.053959	jhonfc9011@hotmail.com	\N	\N
69	183	38	2021-11-15	65	10		2021-11-15 11:26:04.408823	jhonfc9011@hotmail.com	\N	\N
70	183	39	2021-11-15	65	10		2021-11-15 11:26:52.001299	jhonfc9011@hotmail.com	\N	\N
71	183	40	2021-11-15	65	10		2021-11-15 11:27:19.617431	jhonfc9011@hotmail.com	\N	\N
72	188	1	2022-02-27	177	40	Test	2022-02-27 20:04:01.242207	jhonfc9011@hotmail.com	\N	\N
\.


--
-- TOC entry 2621 (class 0 OID 43831)
-- Dependencies: 268
-- Data for Name: tbltrnpagos_cxp; Type: TABLE DATA; Schema: public; Owner: postgres
--

insert into public.tbltrnpagos_cxp (intnumdocumento, numerofactura, intserie, datfecha, intidcliente, 
									numtotal_cobrado, datfechacreo, strusuariocreo)
values (1,	11,	1,	'2022-03-04',	3,	133.30,		'2022-03-04 21:09:41.499168',	'jhonfc9011@hotmail.com')
\.


--
-- TOC entry 2612 (class 0 OID 18985)
-- Dependencies: 256
-- Data for Name: tbltrnregistrocuentas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbltrnregistrocuentas (idregistro, intidcuenta, numdebe, numhaber, numsaldo, strtipo, referencia, datfechacreo, strusariocreo) FROM stdin;
\.


--
-- TOC entry 2614 (class 0 OID 18993)
-- Dependencies: 258
-- Data for Name: tbltrntranferencia; Type: TABLE DATA; Schema: public; Owner: postgres
--

insert into public.tbltrntranferencia (intidtransferencia, intidcuentadebitada, intidcuentaacreditada, 
									   strdescripcion, datfechattranferencia, nummonto, strusuariocreo, 
									   datfechacreo)
values(2, 2,	4,	'Ventas del 10/05/2021',	'2021-05-10',	1700,	'jhonfc9011@hotmail.com',	'2021-05-11 18:05:23')
\.


--
-- TOC entry 2662 (class 0 OID 0)
-- Dependencies: 198
-- Name: tablcatcuentas_intidcuenta_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tablcatcuentas_intidcuenta_seq', 6, true);


--
-- TOC entry 2663 (class 0 OID 0)
-- Dependencies: 200
-- Name: tblcatclientes_intidcliente_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatclientes_intidcliente_seq', 276, true);


--
-- TOC entry 2664 (class 0 OID 0)
-- Dependencies: 202
-- Name: tblcatdescuento_intidimpuesto_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatdescuento_intidimpuesto_seq', 5, true);


--
-- TOC entry 2665 (class 0 OID 0)
-- Dependencies: 204
-- Name: tblcatexistencia_intidserie_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatexistencia_intidserie_seq', 53, true);


--
-- TOC entry 2666 (class 0 OID 0)
-- Dependencies: 207
-- Name: tblcatfacturadetalle_compra_intidserie_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatfacturadetalle_compra_intidserie_seq', 15, true);


--
-- TOC entry 2667 (class 0 OID 0)
-- Dependencies: 208
-- Name: tblcatfacturadetalle_intidserie_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatfacturadetalle_intidserie_seq', 264, true);


--
-- TOC entry 2668 (class 0 OID 0)
-- Dependencies: 211
-- Name: tblcatfacturaencabezado_compra_intidserie_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatfacturaencabezado_compra_intidserie_seq', 16, true);


--
-- TOC entry 2669 (class 0 OID 0)
-- Dependencies: 212
-- Name: tblcatfacturaencabezado_intidserie_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatfacturaencabezado_intidserie_seq', 198, true);


--
-- TOC entry 2670 (class 0 OID 0)
-- Dependencies: 214
-- Name: tblcatformulariodetalle_idfrmdetalle_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatformulariodetalle_idfrmdetalle_seq', 3, true);


--
-- TOC entry 2671 (class 0 OID 0)
-- Dependencies: 216
-- Name: tblcatformularios_idfrm_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatformularios_idfrm_seq', 1, false);


--
-- TOC entry 2672 (class 0 OID 0)
-- Dependencies: 218
-- Name: tblcatgastos_intidclasgasto_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatgastos_intidclasgasto_seq', 9, true);


--
-- TOC entry 2673 (class 0 OID 0)
-- Dependencies: 220
-- Name: tblcatimpuesto_intidimpuesto_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatimpuesto_intidimpuesto_seq', 3, true);


--
-- TOC entry 2674 (class 0 OID 0)
-- Dependencies: 222
-- Name: tblcatingresos_intidclasingreso_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatingresos_intidclasingreso_seq', 1, true);


--
-- TOC entry 2675 (class 0 OID 0)
-- Dependencies: 224
-- Name: tblcatmenu_intidmenu_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatmenu_intidmenu_seq', 1, false);


--
-- TOC entry 2676 (class 0 OID 0)
-- Dependencies: 226
-- Name: tblcatmenuperfil_intidmenuperfil_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatmenuperfil_intidmenuperfil_seq', 44, true);


--
-- TOC entry 2677 (class 0 OID 0)
-- Dependencies: 228
-- Name: tblcatperfilusr_idperfil_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatperfilusr_idperfil_seq', 4, true);


--
-- TOC entry 2678 (class 0 OID 0)
-- Dependencies: 230
-- Name: tblcatperfilusrfrm_idperfilusrfrm_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatperfilusrfrm_idperfilusrfrm_seq', 112, true);


--
-- TOC entry 2679 (class 0 OID 0)
-- Dependencies: 232
-- Name: tblcatperfilusrfrmdetalle_idperfilusrfrmdetalle_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatperfilusrfrmdetalle_idperfilusrfrmdetalle_seq', 68, true);


--
-- TOC entry 2680 (class 0 OID 0)
-- Dependencies: 234
-- Name: tblcatproductos_intidproducto_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatproductos_intidproducto_seq', 53, true);


--
-- TOC entry 2681 (class 0 OID 0)
-- Dependencies: 236
-- Name: tblcatproveedor_intidproveedor_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatproveedor_intidproveedor_seq', 7, true);


--
-- TOC entry 2682 (class 0 OID 0)
-- Dependencies: 238
-- Name: tblcattasacambio_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcattasacambio_id_seq', 918, true);


--
-- TOC entry 2683 (class 0 OID 0)
-- Dependencies: 240
-- Name: tblcattipofactura_intid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcattipofactura_intid_seq', 2, true);


--
-- TOC entry 2684 (class 0 OID 0)
-- Dependencies: 242
-- Name: tblcattipoproducto_intidtipoproducto_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcattipoproducto_intidtipoproducto_seq', 1, false);


--
-- TOC entry 2685 (class 0 OID 0)
-- Dependencies: 244
-- Name: tblcatusuario_intid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tblcatusuario_intid_seq', 6, true);


--
-- TOC entry 2686 (class 0 OID 0)
-- Dependencies: 247
-- Name: tbltempfacturadetalle_compra_intidserie_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbltempfacturadetalle_compra_intidserie_seq', 16, true);


--
-- TOC entry 2687 (class 0 OID 0)
-- Dependencies: 248
-- Name: tbltempfacturadetalle_intidserie_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbltempfacturadetalle_intidserie_seq', 287, true);


--
-- TOC entry 2688 (class 0 OID 0)
-- Dependencies: 260
-- Name: tbltrnajuste_intserieajuste_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbltrnajuste_intserieajuste_seq', 8, true);


--
-- TOC entry 2689 (class 0 OID 0)
-- Dependencies: 265
-- Name: tbltrnajusteinventario_idreg_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbltrnajusteinventario_idreg_seq', 1, true);


--
-- TOC entry 2690 (class 0 OID 0)
-- Dependencies: 250
-- Name: tbltrngastos_intidreggasto_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbltrngastos_intidreggasto_seq', 5, true);


--
-- TOC entry 2691 (class 0 OID 0)
-- Dependencies: 252
-- Name: tbltrningresos_intidregingreso_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbltrningresos_intidregingreso_seq', 2, true);


--
-- TOC entry 2692 (class 0 OID 0)
-- Dependencies: 254
-- Name: tbltrnmovimientos_intid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbltrnmovimientos_intid_seq', 384, true);


--
-- TOC entry 2693 (class 0 OID 0)
-- Dependencies: 267
-- Name: tbltrnpagos_cxp_intnumdocumento_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbltrnpagos_cxp_intnumdocumento_seq', 1, false);


--
-- TOC entry 2694 (class 0 OID 0)
-- Dependencies: 257
-- Name: tbltrnregistrocuentas_idregistro_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbltrnregistrocuentas_idregistro_seq', 1, false);


--
-- TOC entry 2695 (class 0 OID 0)
-- Dependencies: 259
-- Name: tbltrntranferencia_intidtransferencia_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbltrntranferencia_intidtransferencia_seq', 2, true);


--
-- TOC entry 2329 (class 2606 OID 19033)
-- Name: hora hora_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hora
    ADD CONSTRAINT hora_pkey PRIMARY KEY (id);


--
-- TOC entry 2409 (class 2606 OID 19035)
-- Name: tbltrnmovimientos pk_id_movimiento; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrnmovimientos
    ADD CONSTRAINT pk_id_movimiento PRIMARY KEY (intid);


--
-- TOC entry 2331 (class 2606 OID 19037)
-- Name: tablcatcuentas tablcatcuentas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tablcatcuentas
    ADD CONSTRAINT tablcatcuentas_pkey PRIMARY KEY (intidcuenta);


--
-- TOC entry 2333 (class 2606 OID 19039)
-- Name: tblcatclientes tblcatclientes_bigcodcliente_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatclientes
    ADD CONSTRAINT tblcatclientes_bigcodcliente_key UNIQUE (bigcodcliente);


--
-- TOC entry 2335 (class 2606 OID 19041)
-- Name: tblcatclientes tblcatclientes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatclientes
    ADD CONSTRAINT tblcatclientes_pkey PRIMARY KEY (intidcliente);


--
-- TOC entry 2337 (class 2606 OID 19043)
-- Name: tblcatdescuento tblcatdescuento_descripcion_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatdescuento
    ADD CONSTRAINT tblcatdescuento_descripcion_key UNIQUE (descripcion);


--
-- TOC entry 2339 (class 2606 OID 19045)
-- Name: tblcatdescuento tblcatdescuento_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatdescuento
    ADD CONSTRAINT tblcatdescuento_pkey PRIMARY KEY (intidimpuesto);


--
-- TOC entry 2341 (class 2606 OID 19047)
-- Name: tblcatexistencia tblcatexistencia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatexistencia
    ADD CONSTRAINT tblcatexistencia_pkey PRIMARY KEY (intidserie);


--
-- TOC entry 2343 (class 2606 OID 19049)
-- Name: tblcatexistencia tblcatexistencia_strnombreproducto_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatexistencia
    ADD CONSTRAINT tblcatexistencia_strnombreproducto_key UNIQUE (strnombreproducto);


--
-- TOC entry 2347 (class 2606 OID 19051)
-- Name: tblcatfacturadetalle_compra tblcatfacturadetalle_comp_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatfacturadetalle_compra
    ADD CONSTRAINT tblcatfacturadetalle_comp_pkey PRIMARY KEY (intidserie, intidproducto);


--
-- TOC entry 2345 (class 2606 OID 19053)
-- Name: tblcatfacturadetalle tblcatfacturadetalle_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatfacturadetalle
    ADD CONSTRAINT tblcatfacturadetalle_pkey PRIMARY KEY (intidserie, intidproducto);


--
-- TOC entry 2351 (class 2606 OID 19055)
-- Name: tblcatfacturaencabezado_compra tblcatfacturaencabezado_compra_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatfacturaencabezado_compra
    ADD CONSTRAINT tblcatfacturaencabezado_compra_pkey PRIMARY KEY (intidserie);


--
-- TOC entry 2349 (class 2606 OID 19057)
-- Name: tblcatfacturaencabezado tblcatfacturaencabezado_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatfacturaencabezado
    ADD CONSTRAINT tblcatfacturaencabezado_pkey PRIMARY KEY (intidserie);


--
-- TOC entry 2353 (class 2606 OID 19059)
-- Name: tblcatformulariodetalle tblcatformulariodetalle_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatformulariodetalle
    ADD CONSTRAINT tblcatformulariodetalle_pkey PRIMARY KEY (idfrmdetalle);


--
-- TOC entry 2355 (class 2606 OID 19061)
-- Name: tblcatformularios tblcatformularios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatformularios
    ADD CONSTRAINT tblcatformularios_pkey PRIMARY KEY (idfrm);


--
-- TOC entry 2357 (class 2606 OID 19063)
-- Name: tblcatformularios tblcatformularios_strformulario_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatformularios
    ADD CONSTRAINT tblcatformularios_strformulario_key UNIQUE (strformulario);


--
-- TOC entry 2359 (class 2606 OID 19065)
-- Name: tblcatformularios tblcatformularios_strnombreform_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatformularios
    ADD CONSTRAINT tblcatformularios_strnombreform_key UNIQUE (strnombreform);


--
-- TOC entry 2361 (class 2606 OID 19067)
-- Name: tblcatgastos tblcatgastos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatgastos
    ADD CONSTRAINT tblcatgastos_pkey PRIMARY KEY (intidclasgasto);


--
-- TOC entry 2363 (class 2606 OID 19069)
-- Name: tblcatgastos tblcatgastos_strnombrecategoria_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatgastos
    ADD CONSTRAINT tblcatgastos_strnombrecategoria_key UNIQUE (strnombrecategoria);


--
-- TOC entry 2365 (class 2606 OID 19071)
-- Name: tblcatimpuesto tblcatimpuesto_nombre_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatimpuesto
    ADD CONSTRAINT tblcatimpuesto_nombre_key UNIQUE (nombre);


--
-- TOC entry 2367 (class 2606 OID 19073)
-- Name: tblcatimpuesto tblcatimpuesto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatimpuesto
    ADD CONSTRAINT tblcatimpuesto_pkey PRIMARY KEY (intidimpuesto);


--
-- TOC entry 2369 (class 2606 OID 19075)
-- Name: tblcatingresos tblcatingresos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatingresos
    ADD CONSTRAINT tblcatingresos_pkey PRIMARY KEY (intidclasingreso);


--
-- TOC entry 2371 (class 2606 OID 19077)
-- Name: tblcatingresos tblcatingresos_strnombrecategoria_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatingresos
    ADD CONSTRAINT tblcatingresos_strnombrecategoria_key UNIQUE (strnombrecategoria);


--
-- TOC entry 2373 (class 2606 OID 19079)
-- Name: tblcatmenu tblcatmenu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatmenu
    ADD CONSTRAINT tblcatmenu_pkey PRIMARY KEY (intidmenu);


--
-- TOC entry 2375 (class 2606 OID 19081)
-- Name: tblcatmenuperfil tblcatmenuperfil_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatmenuperfil
    ADD CONSTRAINT tblcatmenuperfil_pkey PRIMARY KEY (intidmenuperfil);


--
-- TOC entry 2377 (class 2606 OID 19083)
-- Name: tblcatperfilusr tblcatperfilusr_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatperfilusr
    ADD CONSTRAINT tblcatperfilusr_pkey PRIMARY KEY (idperfil);


--
-- TOC entry 2379 (class 2606 OID 19085)
-- Name: tblcatperfilusr tblcatperfilusr_strperfil_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatperfilusr
    ADD CONSTRAINT tblcatperfilusr_strperfil_key UNIQUE (strperfil);


--
-- TOC entry 2381 (class 2606 OID 19087)
-- Name: tblcatperfilusrfrm tblcatperfilusrfrm_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatperfilusrfrm
    ADD CONSTRAINT tblcatperfilusrfrm_pkey PRIMARY KEY (idperfilusrfrm);


--
-- TOC entry 2383 (class 2606 OID 19089)
-- Name: tblcatperfilusrfrmdetalle tblcatperfilusrfrmdetalle_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatperfilusrfrmdetalle
    ADD CONSTRAINT tblcatperfilusrfrmdetalle_pkey PRIMARY KEY (idperfilusrfrmdetalle);


--
-- TOC entry 2385 (class 2606 OID 19091)
-- Name: tblcatproductos tblcatproductos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatproductos
    ADD CONSTRAINT tblcatproductos_pkey PRIMARY KEY (intidproducto);


--
-- TOC entry 2387 (class 2606 OID 19093)
-- Name: tblcatproveedor tblcatproveedor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatproveedor
    ADD CONSTRAINT tblcatproveedor_pkey PRIMARY KEY (intidproveedor);


--
-- TOC entry 2389 (class 2606 OID 19095)
-- Name: tblcattasacambio tblcattasacambio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcattasacambio
    ADD CONSTRAINT tblcattasacambio_pkey PRIMARY KEY (id);


--
-- TOC entry 2391 (class 2606 OID 19097)
-- Name: tblcattipofactura tblcattipofactura_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcattipofactura
    ADD CONSTRAINT tblcattipofactura_pkey PRIMARY KEY (intid);


--
-- TOC entry 2393 (class 2606 OID 19099)
-- Name: tblcattipofactura tblcattipofactura_tipo_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcattipofactura
    ADD CONSTRAINT tblcattipofactura_tipo_key UNIQUE (tipo);


--
-- TOC entry 2395 (class 2606 OID 19101)
-- Name: tblcattipoproducto tblcattipoproducto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcattipoproducto
    ADD CONSTRAINT tblcattipoproducto_pkey PRIMARY KEY (intidtipoproducto);


--
-- TOC entry 2397 (class 2606 OID 19103)
-- Name: tblcatusuario tblcatusuario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatusuario
    ADD CONSTRAINT tblcatusuario_pkey PRIMARY KEY (intid);


--
-- TOC entry 2399 (class 2606 OID 19105)
-- Name: tblcatusuario tblcatusuario_strcorreo_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatusuario
    ADD CONSTRAINT tblcatusuario_strcorreo_key UNIQUE (strcorreo);


--
-- TOC entry 2403 (class 2606 OID 19107)
-- Name: tbltempfacturadetalle_compra tbltempfacturadetalle_compras_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltempfacturadetalle_compra
    ADD CONSTRAINT tbltempfacturadetalle_compras_pkey PRIMARY KEY (intidserie);


--
-- TOC entry 2401 (class 2606 OID 19109)
-- Name: tbltempfacturadetalle tbltempfacturadetalle_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltempfacturadetalle
    ADD CONSTRAINT tbltempfacturadetalle_pkey PRIMARY KEY (intidserie);


--
-- TOC entry 2417 (class 2606 OID 27417)
-- Name: tbltrnajuste tbltrnajuste_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrnajuste
    ADD CONSTRAINT tbltrnajuste_pkey PRIMARY KEY (intserieajuste);


--
-- TOC entry 2419 (class 2606 OID 36119)
-- Name: tbltrnajusteinventario tbltrnajusteinventario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrnajusteinventario
    ADD CONSTRAINT tbltrnajusteinventario_pkey PRIMARY KEY (idreg);


--
-- TOC entry 2405 (class 2606 OID 19113)
-- Name: tbltrngastos tbltrngastos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrngastos
    ADD CONSTRAINT tbltrngastos_pkey PRIMARY KEY (intidreggasto);


--
-- TOC entry 2407 (class 2606 OID 19115)
-- Name: tbltrningresos tbltrningresos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrningresos
    ADD CONSTRAINT tbltrningresos_pkey PRIMARY KEY (intidregingreso);


--
-- TOC entry 2421 (class 2606 OID 43839)
-- Name: tbltrnpagos_cxp tbltrnpagos_cxp_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrnpagos_cxp
    ADD CONSTRAINT tbltrnpagos_cxp_pkey PRIMARY KEY (intnumdocumento);


--
-- TOC entry 2411 (class 2606 OID 19117)
-- Name: tbltrnpagos tbltrnrecibos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrnpagos
    ADD CONSTRAINT tbltrnrecibos_pkey PRIMARY KEY (intnumdocumento);


--
-- TOC entry 2413 (class 2606 OID 19119)
-- Name: tbltrnregistrocuentas tbltrnregistrocuentas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrnregistrocuentas
    ADD CONSTRAINT tbltrnregistrocuentas_pkey PRIMARY KEY (idregistro);


--
-- TOC entry 2415 (class 2606 OID 19121)
-- Name: tbltrntranferencia tbltrntranferencia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrntranferencia
    ADD CONSTRAINT tbltrntranferencia_pkey PRIMARY KEY (intidtransferencia);


--
-- TOC entry 2425 (class 2606 OID 19122)
-- Name: tblcatformulariodetalle fk_frm_frmdet; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatformulariodetalle
    ADD CONSTRAINT fk_frm_frmdet FOREIGN KEY (idfrm) REFERENCES public.tblcatformularios(idfrm);


--
-- TOC entry 2432 (class 2606 OID 19127)
-- Name: tbltrngastos fk_gasto_cuenta; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrngastos
    ADD CONSTRAINT fk_gasto_cuenta FOREIGN KEY (intidcuenta) REFERENCES public.tablcatcuentas(intidcuenta);


--
-- TOC entry 2433 (class 2606 OID 19132)
-- Name: tbltrningresos fk_ingreso_cuenta; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrningresos
    ADD CONSTRAINT fk_ingreso_cuenta FOREIGN KEY (intidcuenta) REFERENCES public.tablcatcuentas(intidcuenta);


--
-- TOC entry 2434 (class 2606 OID 19137)
-- Name: tbltrnmovimientos fk_movimiento_cuenta; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbltrnmovimientos
    ADD CONSTRAINT fk_movimiento_cuenta FOREIGN KEY (intidcuenta) REFERENCES public.tablcatcuentas(intidcuenta);


--
-- TOC entry 2422 (class 2606 OID 19142)
-- Name: tblcatexistencia fk_producto_existencia; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatexistencia
    ADD CONSTRAINT fk_producto_existencia FOREIGN KEY (intidproducto) REFERENCES public.tblcatproductos(intidproducto);


--
-- TOC entry 2428 (class 2606 OID 19147)
-- Name: tblcatperfilusrfrm form_perfil; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatperfilusrfrm
    ADD CONSTRAINT form_perfil FOREIGN KEY (idfrm) REFERENCES public.tblcatformularios(idfrm);


--
-- TOC entry 2430 (class 2606 OID 19152)
-- Name: tblcatperfilusrfrmdetalle form_perfil_frmdet; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatperfilusrfrmdetalle
    ADD CONSTRAINT form_perfil_frmdet FOREIGN KEY (idfrmdetalle) REFERENCES public.tblcatformulariodetalle(idfrmdetalle);


--
-- TOC entry 2429 (class 2606 OID 19157)
-- Name: tblcatperfilusrfrm formulario_perfil; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatperfilusrfrm
    ADD CONSTRAINT formulario_perfil FOREIGN KEY (idperfil) REFERENCES public.tblcatperfilusr(idperfil);


--
-- TOC entry 2431 (class 2606 OID 19162)
-- Name: tblcatperfilusrfrmdetalle formulario_perfil_frmdet; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatperfilusrfrmdetalle
    ADD CONSTRAINT formulario_perfil_frmdet FOREIGN KEY (idperfil) REFERENCES public.tblcatperfilusr(idperfil);


--
-- TOC entry 2426 (class 2606 OID 19167)
-- Name: tblcatmenuperfil menu_perfilmenu; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatmenuperfil
    ADD CONSTRAINT menu_perfilmenu FOREIGN KEY (intidmenu) REFERENCES public.tblcatmenu(intidmenu);


--
-- TOC entry 2427 (class 2606 OID 19172)
-- Name: tblcatmenuperfil perfil_menuperil; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatmenuperfil
    ADD CONSTRAINT perfil_menuperil FOREIGN KEY (idperfil) REFERENCES public.tblcatperfilusr(idperfil);


--
-- TOC entry 2423 (class 2606 OID 19177)
-- Name: tblcatfacturadetalle pk_encabezado_detalle_fact; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatfacturadetalle
    ADD CONSTRAINT pk_encabezado_detalle_fact FOREIGN KEY (intidfactura) REFERENCES public.tblcatfacturaencabezado(intidserie);


--
-- TOC entry 2424 (class 2606 OID 19182)
-- Name: tblcatfacturadetalle_compra pk_encabezado_detalle_fact_comp; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tblcatfacturadetalle_compra
    ADD CONSTRAINT pk_encabezado_detalle_fact_comp FOREIGN KEY (intidfactura) REFERENCES public.tblcatfacturaencabezado_compra(intidserie);


-- Completed on 2022-04-09 18:14:57

--
-- PostgreSQL database dump complete
--

