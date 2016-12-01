package com.thomsonreuters.cache;


public interface MultiExpireCache<T> {

	public void setExpiration(int seconds, String... keys);

}