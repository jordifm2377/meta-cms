package com.thomsonreuters.model;

import com.google.inject.Singleton;

import com.thomsonreuters.cms.db.DatabaseExecutor;
import com.thomsonreuters.cms.db.ResultObject;
import com.thomsonreuters.cms.db.RowObject;
import com.thomsonreuters.cms.exception.AppErrorException;
import com.thomsonreuters.cms.exception.AppException;
import com.thomsonreuters.datamodel.AttributeDef;
import com.thomsonreuters.query.Query;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

@Singleton
public class AttributeModelImpl implements AttributeModel {
	
	private static final Logger logger = LoggerFactory.getLogger("AttributeModelImpl");

	@Override
	public List<Long> search(String userId, String searchTerm, DatabaseExecutor databaseExecutor) throws SQLException {
		// TODO Auto-generated method stub
		return null;
	}

	@Override
	public AttributeDef getAttribute(String userId, long attrId, DatabaseExecutor databaseExecutor)
		throws AppErrorException, AppException, SQLException {
        
		if(attrId <= 0)
			return null;
		String query = Query.GET_ATTRIBUTE;
        Object[] parameters = new Object[]{attrId};

        ResultObject res = databaseExecutor.retrieveQuery(query, parameters);

        if(res.getRows().size() <= 0) {
        	throw new AppErrorException(AppErrorException.missingTerm);
        }
        logger.debug("Get attribute Id {}", attrId);
        return parseAttributeRow(res.getRows().get(0));

	}

	@Override
	public List<AttributeDef> getAttributeList(String userId, DatabaseExecutor databaseExecutor) 
		throws AppErrorException, AppException, SQLException {
		
		String query = Query.GET_ATTRIBUTES;
        //Object[] parameters = new Object[]{attrId};

        ResultObject res = databaseExecutor.retrieveQuery(query, new Object[]{});
        if(res.getRows().size() <= 0) {
        	return new ArrayList<>();
        }
        List<AttributeDef> attrDefList = new ArrayList<>();
        res.getRows().forEach( row -> attrDefList.add(parseAttributeRow(row)));
        logger.debug("Get attributes");
        
        return attrDefList;
	}

	@Override
	public long insertAttribute(String userId, AttributeDef attributeDef, DatabaseExecutor databaseExecutor)
			 throws AppErrorException, AppException, SQLException {

        String query = Query.INSERT_ATTRIBUTE;
        Object[] parameters = new Object[]{attributeDef.getName(), attributeDef.getCaption(), attributeDef.getDescription()
        		, attributeDef.getType(), attributeDef.getLookupId(), attributeDef.getWidth(), attributeDef.getHeight()
        		, attributeDef.getMaxLength(), attributeDef.getImgWidth(), attributeDef.getImgHeight()
        		, attributeDef.getTag()};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.add);
        }
/*
        if (!Synchronization.trackAdd(tableName, entity.getId(), databaseExecutor)) {
                throw new AppErrorException(AppErrorException.synchronization);
        }
*/
        logger.debug("Adding attribute Id {}", attributeDef.getId());
		return 0;
	}

	@Override
	public long updateAttribute(String userId, AttributeDef attributeDef, DatabaseExecutor databaseExecutor)
			throws AppErrorException, AppException, SQLException {
		
        String query = Query.UPDATE_ATTRIBUTE;
        Object[] parameters = new Object[]{attributeDef.getName(), attributeDef.getCaption(), attributeDef.getDescription()
        		, attributeDef.getType(), attributeDef.getLookupId(), attributeDef.getWidth(), attributeDef.getHeight()
        		, attributeDef.getMaxLength(), attributeDef.getImgWidth(), attributeDef.getImgHeight()
        		, attributeDef.getTag(), attributeDef.getId()};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.update);
        }

        logger.debug("Updating attribute Id {}", attributeDef.getId());
		return 0;
	}

	@Override
	public long deleteAttribute(String userId, long attrId, DatabaseExecutor databaseExecutor) 
			throws AppErrorException, AppException, SQLException {
		
        String query = Query.DELETE_ATTRIBUTE;
        Object[] parameters = new Object[]{attrId};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.delete);
        }

        logger.debug("Deleting attribute Id {}", attrId);

		return 0;
	}

	@Override
	public long enableAttribute(String userId, long attrId, DatabaseExecutor databaseExecutor)
			throws AppErrorException, AppException, SQLException {
        String query = Query.CHANGE_ATTRIBUTE_STATUS;
        Object[] parameters = new Object[]{"Y", attrId};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.update);
        }

        logger.debug("Enabling attribute Id {}", attrId);

		return 0;
	}

	@Override
	public long disableAttribute(String userId, long attrId, DatabaseExecutor databaseExecutor)
			throws AppErrorException, AppException, SQLException {
        String query = Query.CHANGE_ATTRIBUTE_STATUS;
        Object[] parameters = new Object[]{"N", attrId};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.update);
        }

        logger.debug("Disabling attribute Id {}", attrId);

		return 0;
	}

	private AttributeDef parseAttributeRow(RowObject row) {
		AttributeDef attrDef = new AttributeDef();
		attrDef.setId((Integer) row.getRowValue().get("id"));
		attrDef.setName((String)row.getRowValue().get("name"));
		attrDef.setCaption((String)row.getRowValue().getOrDefault("caption", ""));
		attrDef.setDescription((String)row.getRowValue().getOrDefault("description", ""));
		attrDef.setType((String)row.getRowValue().get("type"));
		try {
			attrDef.setLookupId((Integer)row.getRowValue().getOrDefault("lookup_id", 0));
		} catch(Exception e) {
			attrDef.setLookupId(0);
		}
		try {
			attrDef.setWidth((Integer)row.getRowValue().getOrDefault("width", 0));
		} catch(Exception e) {
			attrDef.setWidth(0);
		}
		try {
			attrDef.setHeight((Integer)row.getRowValue().getOrDefault("height", 0));
		} catch(Exception e) {
			attrDef.setHeight(0);
		}
		try {
			attrDef.setMaxLength((Integer)row.getRowValue().getOrDefault("max_length", 0));
		} catch(Exception e) {
			attrDef.setMaxLength(0);
		}
		try {
			attrDef.setImgWidth((Integer)row.getRowValue().getOrDefault("img_width", 0));
		} catch(Exception e) {
			attrDef.setImgWidth(0);
		}	
		try {
			attrDef.setImgHeight((Integer)row.getRowValue().getOrDefault("img_height", 0));
		} catch(Exception e) {
			attrDef.setImgHeight(0);
		}	
		try {
			attrDef.setTag((String)row.getRowValue().getOrDefault("tag", ""));
		} catch(Exception e) {
			attrDef.setTag("");
		}	
		attrDef.setEnabled((String)row.getRowValue().getOrDefault("enabled", "N"));
		return attrDef;
	}


}
