package com.thomsonreuters.cms.db;

import java.util.HashMap;

public class RowObject {
	
	private HashMap<String, Object> rowValue = new HashMap<>();
	
	public RowObject() {
		// default constructor
	}
	
	public RowObject(HashMap<String, Object> rowValue) {
		
		// constructor with required fields
		this.rowValue = rowValue;
	}
	
	// getters
	
	public HashMap<String, Object> getRowValue() {
		return rowValue;
	}
	
	// setters
	
	public void setRowValue(HashMap<String, Object> rowValue) {
		this.rowValue = rowValue;
	}
}
