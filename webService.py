#!/usr/bin/python 
import suds

def wsarchivo():
	url = "http://localhost/wsdl/server.php?wsdl"
	client = suds.client.Client(url)
	print(client)
	res=client.service.HolaMundo("hector")
	print(res)

wsarchivo()




