package com.thomsonreuters.cms.db;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

public class ResultObject {
	
	private HashMap<String, Integer> columnTypes = new HashMap<>();
	private List<RowObject> rows = new ArrayList<>();
	
	public ResultObject() {
		// default constructor
	}
	
	public ResultObject(HashMap<String, Integer> columnTypes, List<RowObject> rows) {
		
		// constructor with required fields
		this.columnTypes = columnTypes;
		this.rows = rows;
	}
	
	// getters
	
	public HashMap<String,Integer> getColumnTypes() {
		return columnTypes;
	}
	
	public List<RowObject> getRows() {
		return rows;
	}
	
	// setters
	
	public void setColumnTypes(HashMap<String, Integer> columnTypes) {
		this.columnTypes = columnTypes;
	}
	
	public void setRows(List<RowObject> rows) {
		this.rows = rows;
	}
}
