<?php

/**
 * Base class that represents a row from the 'gear' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseGear extends BaseObject  implements Persistent {


  const PEER = 'GearPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        GearPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * The value for the search_name field.
	 * @var        string
	 */
	protected $search_name;

	/**
	 * The value for the category_id field.
	 * @var        int
	 */
	protected $category_id;

	/**
	 * The value for the company_id field.
	 * @var        int
	 */
	protected $company_id;

	/**
	 * The value for the ad_id field.
	 * @var        int
	 */
	protected $ad_id;

	/**
	 * The value for the section field.
	 * @var        string
	 */
	protected $section;

	/**
	 * The value for the visible field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $visible;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * The value for the updated_at field.
	 * @var        string
	 */
	protected $updated_at;

	/**
	 * @var        GearCategory
	 */
	protected $aGearCategory;

	/**
	 * @var        GearCompany
	 */
	protected $aGearCompany;

	/**
	 * @var        array GearInfo[] Collection to store aggregation of GearInfo objects.
	 */
	protected $collGearInfos;

	/**
	 * @var        Criteria The criteria used to select the current contents of collGearInfos.
	 */
	private $lastGearInfoCriteria = null;

	/**
	 * @var        array GearTag[] Collection to store aggregation of GearTag objects.
	 */
	protected $collGearTags;

	/**
	 * @var        Criteria The criteria used to select the current contents of collGearTags.
	 */
	private $lastGearTagCriteria = null;

	/**
	 * @var        array GearReview[] Collection to store aggregation of GearReview objects.
	 */
	protected $collGearReviews;

	/**
	 * @var        Criteria The criteria used to select the current contents of collGearReviews.
	 */
	private $lastGearReviewCriteria = null;

	/**
	 * @var        array UserGear[] Collection to store aggregation of UserGear objects.
	 */
	protected $collUserGears;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUserGears.
	 */
	private $lastUserGearCriteria = null;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Initializes internal state of BaseGear object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->visible = 0;
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [name] column value.
	 * 
	 * @return     string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the [search_name] column value.
	 * 
	 * @return     string
	 */
	public function getSearchName()
	{
		return $this->search_name;
	}

	/**
	 * Get the [category_id] column value.
	 * 
	 * @return     int
	 */
	public function getCategoryId()
	{
		return $this->category_id;
	}

	/**
	 * Get the [company_id] column value.
	 * 
	 * @return     int
	 */
	public function getCompanyId()
	{
		return $this->company_id;
	}

	/**
	 * Get the [ad_id] column value.
	 * 
	 * @return     int
	 */
	public function getAdId()
	{
		return $this->ad_id;
	}

	/**
	 * Get the [section] column value.
	 * 
	 * @return     string
	 */
	public function getSection()
	{
		return $this->section;
	}

	/**
	 * Get the [visible] column value.
	 * 
	 * @return     int
	 */
	public function getVisible()
	{
		return $this->visible;
	}

	/**
	 * Get the [optionally formatted] temporal [created_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->created_at === null) {
			return null;
		}


		if ($this->created_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [updated_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->updated_at === null) {
			return null;
		}


		if ($this->updated_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->updated_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     Gear The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = GearPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     Gear The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = GearPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [search_name] column.
	 * 
	 * @param      string $v new value
	 * @return     Gear The current object (for fluent API support)
	 */
	public function setSearchName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->search_name !== $v) {
			$this->search_name = $v;
			$this->modifiedColumns[] = GearPeer::SEARCH_NAME;
		}

		return $this;
	} // setSearchName()

	/**
	 * Set the value of [category_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Gear The current object (for fluent API support)
	 */
	public function setCategoryId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->category_id !== $v) {
			$this->category_id = $v;
			$this->modifiedColumns[] = GearPeer::CATEGORY_ID;
		}

		if ($this->aGearCategory !== null && $this->aGearCategory->getId() !== $v) {
			$this->aGearCategory = null;
		}

		return $this;
	} // setCategoryId()

	/**
	 * Set the value of [company_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Gear The current object (for fluent API support)
	 */
	public function setCompanyId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->company_id !== $v) {
			$this->company_id = $v;
			$this->modifiedColumns[] = GearPeer::COMPANY_ID;
		}

		if ($this->aGearCompany !== null && $this->aGearCompany->getId() !== $v) {
			$this->aGearCompany = null;
		}

		return $this;
	} // setCompanyId()

	/**
	 * Set the value of [ad_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Gear The current object (for fluent API support)
	 */
	public function setAdId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->ad_id !== $v) {
			$this->ad_id = $v;
			$this->modifiedColumns[] = GearPeer::AD_ID;
		}

		return $this;
	} // setAdId()

	/**
	 * Set the value of [section] column.
	 * 
	 * @param      string $v new value
	 * @return     Gear The current object (for fluent API support)
	 */
	public function setSection($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->section !== $v) {
			$this->section = $v;
			$this->modifiedColumns[] = GearPeer::SECTION;
		}

		return $this;
	} // setSection()

	/**
	 * Set the value of [visible] column.
	 * 
	 * @param      int $v new value
	 * @return     Gear The current object (for fluent API support)
	 */
	public function setVisible($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->visible !== $v || $v === 0) {
			$this->visible = $v;
			$this->modifiedColumns[] = GearPeer::VISIBLE;
		}

		return $this;
	} // setVisible()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Gear The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->created_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->created_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = GearPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Gear The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->updated_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->updated_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = GearPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			// First, ensure that we don't have any columns that have been modified which aren't default columns.
			if (array_diff($this->modifiedColumns, array(GearPeer::VISIBLE))) {
				return false;
			}

			if ($this->visible !== 0) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->search_name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->category_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->company_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
			$this->ad_id = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->section = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->visible = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->created_at = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->updated_at = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 10; // 10 = GearPeer::NUM_COLUMNS - GearPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Gear object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aGearCategory !== null && $this->category_id !== $this->aGearCategory->getId()) {
			$this->aGearCategory = null;
		}
		if ($this->aGearCompany !== null && $this->company_id !== $this->aGearCompany->getId()) {
			$this->aGearCompany = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(GearPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = GearPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aGearCategory = null;
			$this->aGearCompany = null;
			$this->collGearInfos = null;
			$this->lastGearInfoCriteria = null;

			$this->collGearTags = null;
			$this->lastGearTagCriteria = null;

			$this->collGearReviews = null;
			$this->lastGearReviewCriteria = null;

			$this->collUserGears = null;
			$this->lastUserGearCriteria = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseGear:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(GearPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			GearPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseGear:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseGear:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(GearPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(GearPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(GearPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseGear:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			GearPeer::addInstanceToPool($this);
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aGearCategory !== null) {
				if ($this->aGearCategory->isModified() || $this->aGearCategory->isNew()) {
					$affectedRows += $this->aGearCategory->save($con);
				}
				$this->setGearCategory($this->aGearCategory);
			}

			if ($this->aGearCompany !== null) {
				if ($this->aGearCompany->isModified() || $this->aGearCompany->isNew()) {
					$affectedRows += $this->aGearCompany->save($con);
				}
				$this->setGearCompany($this->aGearCompany);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = GearPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = GearPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += GearPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collGearInfos !== null) {
				foreach ($this->collGearInfos as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGearTags !== null) {
				foreach ($this->collGearTags as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGearReviews !== null) {
				foreach ($this->collGearReviews as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserGears !== null) {
				foreach ($this->collUserGears as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aGearCategory !== null) {
				if (!$this->aGearCategory->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aGearCategory->getValidationFailures());
				}
			}

			if ($this->aGearCompany !== null) {
				if (!$this->aGearCompany->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aGearCompany->getValidationFailures());
				}
			}


			if (($retval = GearPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collGearInfos !== null) {
					foreach ($this->collGearInfos as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGearTags !== null) {
					foreach ($this->collGearTags as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGearReviews !== null) {
					foreach ($this->collGearReviews as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserGears !== null) {
					foreach ($this->collUserGears as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GearPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getSearchName();
				break;
			case 3:
				return $this->getCategoryId();
				break;
			case 4:
				return $this->getCompanyId();
				break;
			case 5:
				return $this->getAdId();
				break;
			case 6:
				return $this->getSection();
				break;
			case 7:
				return $this->getVisible();
				break;
			case 8:
				return $this->getCreatedAt();
				break;
			case 9:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = GearPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getSearchName(),
			$keys[3] => $this->getCategoryId(),
			$keys[4] => $this->getCompanyId(),
			$keys[5] => $this->getAdId(),
			$keys[6] => $this->getSection(),
			$keys[7] => $this->getVisible(),
			$keys[8] => $this->getCreatedAt(),
			$keys[9] => $this->getUpdatedAt(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GearPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setSearchName($value);
				break;
			case 3:
				$this->setCategoryId($value);
				break;
			case 4:
				$this->setCompanyId($value);
				break;
			case 5:
				$this->setAdId($value);
				break;
			case 6:
				$this->setSection($value);
				break;
			case 7:
				$this->setVisible($value);
				break;
			case 8:
				$this->setCreatedAt($value);
				break;
			case 9:
				$this->setUpdatedAt($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GearPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSearchName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCategoryId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCompanyId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setAdId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setSection($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setVisible($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCreatedAt($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUpdatedAt($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(GearPeer::DATABASE_NAME);

		if ($this->isColumnModified(GearPeer::ID)) $criteria->add(GearPeer::ID, $this->id);
		if ($this->isColumnModified(GearPeer::NAME)) $criteria->add(GearPeer::NAME, $this->name);
		if ($this->isColumnModified(GearPeer::SEARCH_NAME)) $criteria->add(GearPeer::SEARCH_NAME, $this->search_name);
		if ($this->isColumnModified(GearPeer::CATEGORY_ID)) $criteria->add(GearPeer::CATEGORY_ID, $this->category_id);
		if ($this->isColumnModified(GearPeer::COMPANY_ID)) $criteria->add(GearPeer::COMPANY_ID, $this->company_id);
		if ($this->isColumnModified(GearPeer::AD_ID)) $criteria->add(GearPeer::AD_ID, $this->ad_id);
		if ($this->isColumnModified(GearPeer::SECTION)) $criteria->add(GearPeer::SECTION, $this->section);
		if ($this->isColumnModified(GearPeer::VISIBLE)) $criteria->add(GearPeer::VISIBLE, $this->visible);
		if ($this->isColumnModified(GearPeer::CREATED_AT)) $criteria->add(GearPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(GearPeer::UPDATED_AT)) $criteria->add(GearPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(GearPeer::DATABASE_NAME);

		$criteria->add(GearPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Gear (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setSearchName($this->search_name);

		$copyObj->setCategoryId($this->category_id);

		$copyObj->setCompanyId($this->company_id);

		$copyObj->setAdId($this->ad_id);

		$copyObj->setSection($this->section);

		$copyObj->setVisible($this->visible);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getGearInfos() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addGearInfo($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getGearTags() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addGearTag($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getGearReviews() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addGearReview($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserGears() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserGear($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     Gear Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     GearPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new GearPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a GearCategory object.
	 *
	 * @param      GearCategory $v
	 * @return     Gear The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setGearCategory(GearCategory $v = null)
	{
		if ($v === null) {
			$this->setCategoryId(NULL);
		} else {
			$this->setCategoryId($v->getId());
		}

		$this->aGearCategory = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the GearCategory object, it will not be re-added.
		if ($v !== null) {
			$v->addGear($this);
		}

		return $this;
	}


	/**
	 * Get the associated GearCategory object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     GearCategory The associated GearCategory object.
	 * @throws     PropelException
	 */
	public function getGearCategory(PropelPDO $con = null)
	{
		if ($this->aGearCategory === null && ($this->category_id !== null)) {
			$c = new Criteria(GearCategoryPeer::DATABASE_NAME);
			$c->add(GearCategoryPeer::ID, $this->category_id);
			$this->aGearCategory = GearCategoryPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aGearCategory->addGears($this);
			 */
		}
		return $this->aGearCategory;
	}

	/**
	 * Declares an association between this object and a GearCompany object.
	 *
	 * @param      GearCompany $v
	 * @return     Gear The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setGearCompany(GearCompany $v = null)
	{
		if ($v === null) {
			$this->setCompanyId(NULL);
		} else {
			$this->setCompanyId($v->getId());
		}

		$this->aGearCompany = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the GearCompany object, it will not be re-added.
		if ($v !== null) {
			$v->addGear($this);
		}

		return $this;
	}


	/**
	 * Get the associated GearCompany object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     GearCompany The associated GearCompany object.
	 * @throws     PropelException
	 */
	public function getGearCompany(PropelPDO $con = null)
	{
		if ($this->aGearCompany === null && ($this->company_id !== null)) {
			$c = new Criteria(GearCompanyPeer::DATABASE_NAME);
			$c->add(GearCompanyPeer::ID, $this->company_id);
			$this->aGearCompany = GearCompanyPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aGearCompany->addGears($this);
			 */
		}
		return $this->aGearCompany;
	}

	/**
	 * Clears out the collGearInfos collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addGearInfos()
	 */
	public function clearGearInfos()
	{
		$this->collGearInfos = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collGearInfos collection (array).
	 *
	 * By default this just sets the collGearInfos collection to an empty array (like clearcollGearInfos());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initGearInfos()
	{
		$this->collGearInfos = array();
	}

	/**
	 * Gets an array of GearInfo objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Gear has previously been saved, it will retrieve
	 * related GearInfos from storage. If this Gear is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array GearInfo[]
	 * @throws     PropelException
	 */
	public function getGearInfos($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(GearPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGearInfos === null) {
			if ($this->isNew()) {
			   $this->collGearInfos = array();
			} else {

				$criteria->add(GearInfoPeer::GEAR_ID, $this->id);

				GearInfoPeer::addSelectColumns($criteria);
				$this->collGearInfos = GearInfoPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GearInfoPeer::GEAR_ID, $this->id);

				GearInfoPeer::addSelectColumns($criteria);
				if (!isset($this->lastGearInfoCriteria) || !$this->lastGearInfoCriteria->equals($criteria)) {
					$this->collGearInfos = GearInfoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGearInfoCriteria = $criteria;
		return $this->collGearInfos;
	}

	/**
	 * Returns the number of related GearInfo objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related GearInfo objects.
	 * @throws     PropelException
	 */
	public function countGearInfos(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(GearPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collGearInfos === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(GearInfoPeer::GEAR_ID, $this->id);

				$count = GearInfoPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(GearInfoPeer::GEAR_ID, $this->id);

				if (!isset($this->lastGearInfoCriteria) || !$this->lastGearInfoCriteria->equals($criteria)) {
					$count = GearInfoPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collGearInfos);
				}
			} else {
				$count = count($this->collGearInfos);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a GearInfo object to this object
	 * through the GearInfo foreign key attribute.
	 *
	 * @param      GearInfo $l GearInfo
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGearInfo(GearInfo $l)
	{
		if ($this->collGearInfos === null) {
			$this->initGearInfos();
		}
		if (!in_array($l, $this->collGearInfos, true)) { // only add it if the **same** object is not already associated
			array_push($this->collGearInfos, $l);
			$l->setGear($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Gear is new, it will return
	 * an empty collection; or if this Gear has previously
	 * been saved, it will retrieve related GearInfos from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Gear.
	 */
	public function getGearInfosJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(GearPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGearInfos === null) {
			if ($this->isNew()) {
				$this->collGearInfos = array();
			} else {

				$criteria->add(GearInfoPeer::GEAR_ID, $this->id);

				$this->collGearInfos = GearInfoPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GearInfoPeer::GEAR_ID, $this->id);

			if (!isset($this->lastGearInfoCriteria) || !$this->lastGearInfoCriteria->equals($criteria)) {
				$this->collGearInfos = GearInfoPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastGearInfoCriteria = $criteria;

		return $this->collGearInfos;
	}

	/**
	 * Clears out the collGearTags collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addGearTags()
	 */
	public function clearGearTags()
	{
		$this->collGearTags = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collGearTags collection (array).
	 *
	 * By default this just sets the collGearTags collection to an empty array (like clearcollGearTags());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initGearTags()
	{
		$this->collGearTags = array();
	}

	/**
	 * Gets an array of GearTag objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Gear has previously been saved, it will retrieve
	 * related GearTags from storage. If this Gear is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array GearTag[]
	 * @throws     PropelException
	 */
	public function getGearTags($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(GearPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGearTags === null) {
			if ($this->isNew()) {
			   $this->collGearTags = array();
			} else {

				$criteria->add(GearTagPeer::GEAR_ID, $this->id);

				GearTagPeer::addSelectColumns($criteria);
				$this->collGearTags = GearTagPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GearTagPeer::GEAR_ID, $this->id);

				GearTagPeer::addSelectColumns($criteria);
				if (!isset($this->lastGearTagCriteria) || !$this->lastGearTagCriteria->equals($criteria)) {
					$this->collGearTags = GearTagPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGearTagCriteria = $criteria;
		return $this->collGearTags;
	}

	/**
	 * Returns the number of related GearTag objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related GearTag objects.
	 * @throws     PropelException
	 */
	public function countGearTags(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(GearPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collGearTags === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(GearTagPeer::GEAR_ID, $this->id);

				$count = GearTagPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(GearTagPeer::GEAR_ID, $this->id);

				if (!isset($this->lastGearTagCriteria) || !$this->lastGearTagCriteria->equals($criteria)) {
					$count = GearTagPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collGearTags);
				}
			} else {
				$count = count($this->collGearTags);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a GearTag object to this object
	 * through the GearTag foreign key attribute.
	 *
	 * @param      GearTag $l GearTag
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGearTag(GearTag $l)
	{
		if ($this->collGearTags === null) {
			$this->initGearTags();
		}
		if (!in_array($l, $this->collGearTags, true)) { // only add it if the **same** object is not already associated
			array_push($this->collGearTags, $l);
			$l->setGear($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Gear is new, it will return
	 * an empty collection; or if this Gear has previously
	 * been saved, it will retrieve related GearTags from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Gear.
	 */
	public function getGearTagsJoinTag($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(GearPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGearTags === null) {
			if ($this->isNew()) {
				$this->collGearTags = array();
			} else {

				$criteria->add(GearTagPeer::GEAR_ID, $this->id);

				$this->collGearTags = GearTagPeer::doSelectJoinTag($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GearTagPeer::GEAR_ID, $this->id);

			if (!isset($this->lastGearTagCriteria) || !$this->lastGearTagCriteria->equals($criteria)) {
				$this->collGearTags = GearTagPeer::doSelectJoinTag($criteria, $con, $join_behavior);
			}
		}
		$this->lastGearTagCriteria = $criteria;

		return $this->collGearTags;
	}

	/**
	 * Clears out the collGearReviews collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addGearReviews()
	 */
	public function clearGearReviews()
	{
		$this->collGearReviews = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collGearReviews collection (array).
	 *
	 * By default this just sets the collGearReviews collection to an empty array (like clearcollGearReviews());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initGearReviews()
	{
		$this->collGearReviews = array();
	}

	/**
	 * Gets an array of GearReview objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Gear has previously been saved, it will retrieve
	 * related GearReviews from storage. If this Gear is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array GearReview[]
	 * @throws     PropelException
	 */
	public function getGearReviews($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(GearPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGearReviews === null) {
			if ($this->isNew()) {
			   $this->collGearReviews = array();
			} else {

				$criteria->add(GearReviewPeer::GEAR_ID, $this->id);

				GearReviewPeer::addSelectColumns($criteria);
				$this->collGearReviews = GearReviewPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GearReviewPeer::GEAR_ID, $this->id);

				GearReviewPeer::addSelectColumns($criteria);
				if (!isset($this->lastGearReviewCriteria) || !$this->lastGearReviewCriteria->equals($criteria)) {
					$this->collGearReviews = GearReviewPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGearReviewCriteria = $criteria;
		return $this->collGearReviews;
	}

	/**
	 * Returns the number of related GearReview objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related GearReview objects.
	 * @throws     PropelException
	 */
	public function countGearReviews(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(GearPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collGearReviews === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(GearReviewPeer::GEAR_ID, $this->id);

				$count = GearReviewPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(GearReviewPeer::GEAR_ID, $this->id);

				if (!isset($this->lastGearReviewCriteria) || !$this->lastGearReviewCriteria->equals($criteria)) {
					$count = GearReviewPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collGearReviews);
				}
			} else {
				$count = count($this->collGearReviews);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a GearReview object to this object
	 * through the GearReview foreign key attribute.
	 *
	 * @param      GearReview $l GearReview
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGearReview(GearReview $l)
	{
		if ($this->collGearReviews === null) {
			$this->initGearReviews();
		}
		if (!in_array($l, $this->collGearReviews, true)) { // only add it if the **same** object is not already associated
			array_push($this->collGearReviews, $l);
			$l->setGear($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Gear is new, it will return
	 * an empty collection; or if this Gear has previously
	 * been saved, it will retrieve related GearReviews from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Gear.
	 */
	public function getGearReviewsJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(GearPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGearReviews === null) {
			if ($this->isNew()) {
				$this->collGearReviews = array();
			} else {

				$criteria->add(GearReviewPeer::GEAR_ID, $this->id);

				$this->collGearReviews = GearReviewPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GearReviewPeer::GEAR_ID, $this->id);

			if (!isset($this->lastGearReviewCriteria) || !$this->lastGearReviewCriteria->equals($criteria)) {
				$this->collGearReviews = GearReviewPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastGearReviewCriteria = $criteria;

		return $this->collGearReviews;
	}

	/**
	 * Clears out the collUserGears collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserGears()
	 */
	public function clearUserGears()
	{
		$this->collUserGears = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserGears collection (array).
	 *
	 * By default this just sets the collUserGears collection to an empty array (like clearcollUserGears());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initUserGears()
	{
		$this->collUserGears = array();
	}

	/**
	 * Gets an array of UserGear objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Gear has previously been saved, it will retrieve
	 * related UserGears from storage. If this Gear is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array UserGear[]
	 * @throws     PropelException
	 */
	public function getUserGears($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(GearPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserGears === null) {
			if ($this->isNew()) {
			   $this->collUserGears = array();
			} else {

				$criteria->add(UserGearPeer::GEAR_ID, $this->id);

				UserGearPeer::addSelectColumns($criteria);
				$this->collUserGears = UserGearPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserGearPeer::GEAR_ID, $this->id);

				UserGearPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserGearCriteria) || !$this->lastUserGearCriteria->equals($criteria)) {
					$this->collUserGears = UserGearPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserGearCriteria = $criteria;
		return $this->collUserGears;
	}

	/**
	 * Returns the number of related UserGear objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserGear objects.
	 * @throws     PropelException
	 */
	public function countUserGears(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(GearPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collUserGears === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(UserGearPeer::GEAR_ID, $this->id);

				$count = UserGearPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserGearPeer::GEAR_ID, $this->id);

				if (!isset($this->lastUserGearCriteria) || !$this->lastUserGearCriteria->equals($criteria)) {
					$count = UserGearPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collUserGears);
				}
			} else {
				$count = count($this->collUserGears);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a UserGear object to this object
	 * through the UserGear foreign key attribute.
	 *
	 * @param      UserGear $l UserGear
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserGear(UserGear $l)
	{
		if ($this->collUserGears === null) {
			$this->initUserGears();
		}
		if (!in_array($l, $this->collUserGears, true)) { // only add it if the **same** object is not already associated
			array_push($this->collUserGears, $l);
			$l->setGear($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Gear is new, it will return
	 * an empty collection; or if this Gear has previously
	 * been saved, it will retrieve related UserGears from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Gear.
	 */
	public function getUserGearsJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(GearPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserGears === null) {
			if ($this->isNew()) {
				$this->collUserGears = array();
			} else {

				$criteria->add(UserGearPeer::GEAR_ID, $this->id);

				$this->collUserGears = UserGearPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserGearPeer::GEAR_ID, $this->id);

			if (!isset($this->lastUserGearCriteria) || !$this->lastUserGearCriteria->equals($criteria)) {
				$this->collUserGears = UserGearPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastUserGearCriteria = $criteria;

		return $this->collUserGears;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collGearInfos) {
				foreach ((array) $this->collGearInfos as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collGearTags) {
				foreach ((array) $this->collGearTags as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collGearReviews) {
				foreach ((array) $this->collGearReviews as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserGears) {
				foreach ((array) $this->collUserGears as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collGearInfos = null;
		$this->collGearTags = null;
		$this->collGearReviews = null;
		$this->collUserGears = null;
			$this->aGearCategory = null;
			$this->aGearCompany = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseGear:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseGear::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseGear
