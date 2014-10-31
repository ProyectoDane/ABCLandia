package com.example.abclandia;

import android.graphics.Color;
import android.os.Bundle;
import android.widget.GridView;

import com.example.abclandia.graphics.JustLetterFiveRenderer;
import com.example.abclandia.graphics.JustLetterRenderer;
import com.example.abclandia.graphics.JustWordRenderer;
import com.example.abclandia.graphics.LetterWordRenderer;
import com.example.abclandia.graphics.Renderer;
import com.frba.abclandia.R;
import com.frba.abclandia.adapters.CardViewAdapter;
import com.frba.abclandia.dragdrop.DragController;
import com.frba.abclandia.dragdrop.DragLayer;
import com.frba.abclandia.stringformatter.StringWithoutLastLetter;

public class GameFiveActivity extends GameActivity {
	
	public static final int TOTAL_JOINS = 3;

	private GridView mGridViewLeft;
	private GridView mGridViewRight;

	private static String CLASS_NAME = "com.example.abclandia.GameFiveActivity";
	private static int GAME_NUMBER = 5;

	/**
	 * Called when the activity is first created.
	 */
	@Override
	public void onCreate(Bundle savedInstanceState) {

		mGameNumber = GAME_NUMBER;
		mGameClassName = CLASS_NAME;
		mTotalJoins = TOTAL_JOINS;
		super.onCreate(savedInstanceState);
		
		setContentView(R.layout.game_four_five_activity);
		
		mGridViewLeft = (GridView) findViewById(R.id.gridViewLeft);
		mGridViewRight = (GridView) findViewById(R.id.gridViewRight);
		mGridViewLeft.setAdapter(new CardViewAdapter(data, this,
				new JustLetterFiveRenderer(this), R.layout.game_one_card_view));
		
		Renderer justWordRenderer = new JustWordRenderer(this);
		justWordRenderer.setWordFormatter(new StringWithoutLastLetter());
		mGridViewRight.setAdapter(new CardViewAdapter(data, this,
				justWordRenderer, R.layout.game_one_card_view));

		
		mDragController = new DragController(this);
		mDragLayer = (DragLayer) findViewById(R.id.drag_layer);
		mDragLayer.setDragController(mDragController);
		mDragController.setDragListener(mDragLayer);
		
		mDragLayer.setGridViewLeft(mGridViewLeft);
		mDragLayer.setGridViewRight(mGridViewRight);

		

		mAudio.loadLetterSoungs(data);
		mDroppedRenderer = new LetterWordRenderer(this);
		mDroppedRenderer.setRectangleColorBorder(Color.GREEN);

	}

}
