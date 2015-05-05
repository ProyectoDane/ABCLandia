package com.example.abclandia.graphics;

import android.content.ClipData;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.graphics.Rect;
import android.util.AttributeSet;
import android.view.View;
import android.widget.GridView;

import com.example.abclandia.Card;
import com.example.abclandia.GameActivity;
import com.example.abclandia.GameSixActivity;
import com.frba.abclandia.adapters.CardViewAdapter;
import com.frba.abclandia.dragdrop.DragShadow;
import com.frba.abclandia.dragdrop.DragSource;
import com.frba.abclandia.dragdrop.DropTarget;
import com.frba.abclandia.utils.Util;



public class CardView extends View implements DragSource, DropTarget {
	
	private Card mCard;
	private Renderer mRenderer;
	private Paint mTextPaint, mRectanglePaint;
	private int rectangleWidth, rectangleHeight;
	private Context mContext;

	private boolean mAllowDrag = true;
	private boolean isDropTarget = true;
	private boolean isDoubleMatching = false;
	private boolean firstMatching = false;

	private Bitmap imageBitmap; 
	
	public boolean mEmpty = true;
	public CardViewAdapter mAdapter;
	
	 

	public CardView(Context context) {
		super(context);
	}
	
	public CardView(Context context, AttributeSet attrs) {
        super(context, attrs);

        mContext =  context;
	}
	
	public int getCardId(){
		return mCard.getId();
	}
	
	public String getCardLetter(){
		return mCard.getLetter();
	}
	
	public boolean isEmptyCard(){
		return mCard.isEmptyCard();
	}
	
	public void setCard(Card card){
		mCard = card;
	}
	
	public void createImageBitmap(boolean imageAttached){
		if (!mCard.isEmptyCard() && imageAttached)
			imageBitmap = Util.getBitmapFromAsset(mContext.getAssets(), mCard.getImagePath());
			
		
	}
	public void setRenderer(Renderer renderer){
		mRenderer = renderer;
	}
	public Renderer getRenderer(){
		return mRenderer;
	}
	public void setAllowDrag(boolean allowDrag){
		mAllowDrag = allowDrag;
	}
	public void setDoubleMatching(boolean flag){
		isDoubleMatching = flag;
	}
	public boolean isFirstMatching(){
		return firstMatching;
	}
	
	public void setDropeable(boolean flag){
		isDropTarget = flag;
		
	}
	
	@Override
	public boolean isDropTarget(){
		return isDropTarget;
	}
	
	
	@Override
	protected void onDraw(Canvas canvas) {
		   super.onDraw(canvas);
		   
		   rectangleWidth = getMeasuredWidth();
		   rectangleHeight = getMeasuredHeight();
		
		   mRenderer.Render(canvas, rectangleWidth, rectangleHeight, mRectanglePaint, 
				   	mTextPaint, mCard, imageBitmap);
	}
	
	@Override 
	protected void onMeasure(int widthMeasureSpec, int heightMeasureSpec){
	   super.onMeasure(widthMeasureSpec, heightMeasureSpec);
	   int w = getMeasuredWidth();
	   int h = getMeasuredHeight();
	   setMeasuredDimension(w, h);
	}
 
	@Override
    protected void onSizeChanged(int w, int h, int oldw, int oldh) {
        super.onSizeChanged(w, h, oldw, oldh);
	}
    
   @Override
	public boolean allowDrag() {
		return mAllowDrag;
	}

	@Override
	public ClipData clipDataForDragDrop() {
		// TODO Auto-generated method stub
		return null;
	}
	
	@Override
	public View dragDropView() {
		return this;
	}
	/**
	 * This method is called at the start of a drag-drop operation so the object being
	 * dragged knows that it is being dragged.
	 * 
	 */
	@Override
	public void onDragStarted() {
		setVisibility(View.GONE);		
	}

	@Override
	public void onDropCompleted(DropTarget target, boolean success) {
		if (!success){
			setVisibility(View.VISIBLE);
		} else {
			isDropTarget = false;
		}
	}

	@Override
	public void onDrop(DragSource source, int x, int y, int xOffset,
			int yOffset, DragShadow dragView, Object dragInfo) {
	
			CardView cardSource = (CardView) source;
			
			if (isDoubleMatching && !firstMatching && !cardSource.isFirstMatching()  ){
				firstMatching = true;
				mRenderer = ((GameSixActivity) mContext).getFirstMatchedRenderer();
			}
			else {
				mRenderer = ((GameActivity) mContext).getMatchedRenderer();
				this.mAllowDrag = false;
			}
				
			invalidate();
	}
	
	@Override
	public void onDragEnter(DragSource source, int x, int y, int xOffset,
			int yOffset, DragShadow dragView, Object dragInfo) {
		// TODO Auto-generated method stub
		
	}
	

	@Override
	public void onDragOver(DragSource source, int x, int y, int xOffset,
			int yOffset, DragShadow dragView, Object dragInfo) {
		// TODO Auto-generated method stub
	}

	@Override
	public void onDragExit(DragSource source, int x, int y, int xOffset,
			int yOffset, DragShadow dragView, Object dragInfo) {
		// TODO Auto-generated method stub
	}

	@Override
	public boolean acceptDrop(DragSource source, int x, int y, int xOffset,
			int yOffset, DragShadow dragView, Object dragInfo) {
		CardView cardViewSource = (CardView) source;
		if (isDoubleMatching){
			return validateMatchingExcersiseSix(cardViewSource);
		} else {
			if (this.getCardId() == cardViewSource.getCardId()){
				return true;
			}else {
				return false;
		}
		
		
		
		}
	}

	@Override
	public Rect estimateDropLocation(DragSource source, int x, int y,
			int xOffset, int yOffset, DragShadow dragView, Object dragInfo,
			Rect recycle) {
		// TODO Auto-generated method stub
		return null;
	}
	
	private boolean validateMatchingExcersiseSix(CardView cardViewSource){
		if (this.getCardId() != cardViewSource.getCardId()){
			return false;
		} else {
			GridView targetCardContainer = (GridView) this.getParent();
			GridView sourceCardContainer = (GridView) cardViewSource.getParent();
			String tagTarget = targetCardContainer.getTag().toString();
			String tagSource = sourceCardContainer.getTag().toString();
			if (tagTarget.equals("center") && tagSource.equals("left") || 
					tagTarget.equals("left") && tagSource.equals("center") ){
					return true;
			} else if (this.firstMatching == true || cardViewSource.firstMatching == true){
					return true;
			}
					else return false;
		}
		
	}
	
}
