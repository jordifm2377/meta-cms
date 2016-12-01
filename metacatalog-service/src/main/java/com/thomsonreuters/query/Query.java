package com.thomsonreuters.query;

//top-level static class behavior
public final class Query {
	
	public static final String GET_ATTRIBUTE = "SELECT * FROM metadb_attributes "
			+ "WHERE id = ?";

	public static final String GET_ATTRIBUTES = "SELECT * FROM metadb_attributes";

	public static final String INSERT_ATTRIBUTE = "INSERT INTO metadb_attributes "
			+ "(name, caption, description, type, lookup_id, width, height, max_length, "
			+ "img_width, img_height, tag, enabled) "
			+ "VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Y')";
	
	public static final String UPDATE_ATTRIBUTE = "UPDATE metadb_attributes "
			+ "SET name = ? "
			+ ", caption = ? "
			+ ", description = ? "
			+ ", type = ? "
			+ ", lookup_id = ? "
			+ ", width = ? "
			+ ", height = ? "
			+ ", max_length = ? "
			+ ", img_width = ? "
			+ ", img_height = ? "
			+ ", tag = ? "
			+ "WHERE id = ?";

	public static final String CHANGE_ATTRIBUTE_STATUS = "UPDATE metadb_attributes "
			+ "SET enabled = ? "
			+ "WHERE id = ?";

	public static final String DELETE_ATTRIBUTE = "DELETE FROM metadb_attributes "
			+ "WHERE id = ?";

	
	
	public static final String GET_ENTITY = "SELECT * FROM metadb_entities "
			+ "WHERE id = ?";

	public static final String GET_ENTITIES = "SELECT * FROM metadb_entities";

	public static final String INSERT_ENTITY = "INSERT INTO metadb_entities "
			+ "(name, caption, description, grp_id, grp_order, tag, enabled) "
			+ "VALUES(?, ?, ?, ?, ?, ?, 'Y')";
	
	public static final String UPDATE_ENTITY = "UPDATE metadb_entities "
			+ "SET name = ? "
			+ ", caption = ? "
			+ ", description = ? "
			+ ", grp_id = ? "
			+ ", grp_order = ? "
			+ ", tag = ? "
			+ "WHERE id = ?";

	public static final String CHANGE_ENTITY_STATUS = "UPDATE metadb_entities "
			+ "SET enabled = ? "
			+ "WHERE id = ?";

	public static final String DELETE_ENTITY = "DELETE FROM metadb_entities "
			+ "WHERE id = ?";

	
	
	public static final String GET_ENTITY_ATTRIBUTES_BY_ENTITY = "SELECT * FROM metadb_entity_attributes "
			+ "WHERE entity_id = ?";

	public static final String GET_ENTITY_ATTRIBUTE = "SELECT * FROM metadb_entity_attributes "
			+ "WHERE id = ?";

	public static final String GET_ENTITIES_ATTRIBUTES = "SELECT * FROM metadb_entity_attributes";

	
	public static final String INSERT_ENTITY_ATTRIBUTE = "INSERT INTO metadb_entity_attributes "
			+ "(entity_id, atri_id, rel_id, position_row, position_column, width, height, img_width, img_height "
			+ ", order_key, mandatory, enabled) "
			+ "VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Y')";
	
	public static final String UPDATE_ENTITY_ATTRIBUTE = "UPDATE metadb_entity_attributes "
			+ "SET entity_id = ? "
			+ ", atri_id = ? "
			+ ", rel_id = ? "
			+ ", position_row = ? "
			+ ", position_column = ? "
			+ ", width = ? "
			+ ", height = ? "
			+ ", img_width = ? "
			+ ", img_height = ? "
			+ ", order_key = ? "
			+ ", mandatory = ? "
			+ "WHERE id = ?";

	public static final String CHANGE_ENTITY_ATTRIBUTE_STATUS = "UPDATE metadb_entity_attributes "
			+ "SET enabled = ? "
			+ "WHERE id = ?";

	public static final String DELETE_ENTITY_ATTRIBUTE = "DELETE FROM metadb_entity_attributes "
			+ "WHERE id = ?";

	
	
	public static final String GET_RELATION = "SELECT * FROM metadb_relations "
			+ "WHERE id = ?";

	public static final String GET_RELATIONS = "SELECT * FROM metadb_relations";

	
	public static final String INSERT_RELATION = "INSERT INTO metadb_relations "
			+ "(name, caption, description, parent_entity_id, child_entity_id, order_type, tag, enabled) "
			+ "VALUES(?, ?, ?, ?, ?, ?, ?, 'Y')";

	public static final String UPDATE_RELATION = "UPDATE metadb_relations "
			+ "SET name = ? "
			+ ", caption = ? "
			+ ", description = ? "
			+ ", parent_entity_id = ? "
			+ ", child_entity_id = ? "
			+ ", order_type = ? "
			+ ", tag = ? "
			+ "WHERE id = ?";

	public static final String CHANGE_RELATION_STATUS = "UPDATE metadb_relations "
			+ "SET enabled = ? "
			+ "WHERE id = ?";

	public static final String DELETE_RELATION = "DELETE FROM metadb_relations "
			+ "WHERE id = ?";
	
	public static final String GET_LOOKUP = "SELECT * FROM metadb_lookups WHERE id = ?";
	
	public static final String GET_LOOKUPS = "SELECT * FROM metadb_lookups";

	public static final String GET_LOOKUP_VALUES = "SELECT * FROM metadb_lookups_values WHERE lookup_id = ? ORDER by ordre";
	
	private Query() {
		// private default constructor
	}

}
